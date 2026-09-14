<?php

namespace App\Content;

use App\Enums\QuestionRole;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Reads the curriculum content tree (database/content) and upserts it into the
 * database. Layout:
 *
 *   <subject-dir>/subject.yaml
 *   <subject-dir>/<NN-area>/area.yaml
 *   <subject-dir>/<NN-area>/<NN-topic>.md          (frontmatter + "## Erklärung" + "## Hefteintrag")
 *   <subject-dir>/<NN-area>/<NN-topic>.quiz.yaml   (list of test questions)
 *
 * Inside the explanation, "::: check … :::" fences hold inline questions (YAML body).
 * They are stored as questions with role "check" and replaced by "<!-- check:N -->"
 * markers so the page can interleave text and practice.
 */
class ContentImporter
{
    /** @var array{subjects: int, areas: int, topics: int, questions: int} */
    private array $stats = ['subjects' => 0, 'areas' => 0, 'topics' => 0, 'questions' => 0];

    public function __construct(private readonly string $root) {}

    public static function default(): self
    {
        return new self(database_path('content'));
    }

    /**
     * @return array{subjects: int, areas: int, topics: int, questions: int}
     */
    public function import(): array
    {
        $this->stats = ['subjects' => 0, 'areas' => 0, 'topics' => 0, 'questions' => 0];

        foreach (File::directories($this->root) as $subjectDir) {
            $subjectFile = $subjectDir.'/subject.yaml';

            if (! File::exists($subjectFile)) {
                continue;
            }

            $this->importSubject($subjectDir, $subjectFile);
        }

        return $this->stats;
    }

    private function importSubject(string $dir, string $file): void
    {
        $data = $this->yaml($file);

        $subject = Subject::updateOrCreate(
            ['slug' => $data['slug'] ?? basename($dir)],
            collect($data)->only(['name', 'description', 'icon', 'color', 'grade', 'school_type', 'state', 'curriculum_version', 'sort', 'optional'])->all(),
        );
        $this->stats['subjects']++;

        foreach (File::directories($dir) as $areaDir) {
            $areaFile = $areaDir.'/area.yaml';

            if (File::exists($areaFile)) {
                $this->importArea($subject, $areaDir, $areaFile);
            }
        }
    }

    private function importArea(Subject $subject, string $dir, string $file): void
    {
        $data = $this->yaml($file);
        [$sort, $slug] = $this->splitPrefix(basename($dir));

        $area = TopicArea::updateOrCreate(
            ['subject_id' => $subject->id, 'slug' => $data['slug'] ?? $slug],
            [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'curriculum_ref' => $data['curriculum_ref'] ?? null,
                'sort' => $data['sort'] ?? $sort,
            ],
        );
        $this->stats['areas']++;

        $topicFiles = collect(File::files($dir))
            ->filter(fn (SplFileInfo $f) => $f->getExtension() === 'md')
            ->sortBy(fn (SplFileInfo $f) => $f->getFilename());

        foreach ($topicFiles as $topicFile) {
            $this->importTopic($area, $topicFile);
        }
    }

    private function importTopic(TopicArea $area, SplFileInfo $file): void
    {
        [$frontmatter, $body] = $this->parseMarkdown($file->getContents(), $file->getPathname());
        [$sort, $slug] = $this->splitPrefix($file->getFilenameWithoutExtension());
        [$explanation, $notebook] = $this->splitSections($body, $file->getPathname());
        [$explanation, $checks] = $this->extractChecks($explanation);

        $topic = Topic::updateOrCreate(
            ['topic_area_id' => $area->id, 'slug' => $frontmatter['slug'] ?? $slug],
            [
                'title' => $frontmatter['title'],
                'intro' => $frontmatter['intro'] ?? null,
                'explanation' => $explanation,
                'notebook_entry' => $notebook,
                'reflect_prompt' => $frontmatter['reflect'] ?? null,
                'curriculum_ref' => $frontmatter['curriculum_ref'] ?? null,
                'estimated_minutes' => $frontmatter['estimated_minutes'] ?? 20,
                'pass_percent' => $frontmatter['pass_percent'] ?? 70,
                'sort' => $frontmatter['sort'] ?? $sort,
            ],
        );
        $this->stats['topics']++;

        $quizFile = $file->getPath().'/'.$file->getFilenameWithoutExtension().'.quiz.yaml';
        $testQuestions = File::exists($quizFile) ? $this->yamlList($quizFile) : [];

        $this->importQuestions($topic, $testQuestions, $checks, $quizFile);
    }

    /**
     * @param  array<int, array<string, mixed>>  $tests
     * @param  array<int, array<string, mixed>>  $checks
     */
    private function importQuestions(Topic $topic, array $tests, array $checks, string $file): void
    {
        $keys = [];
        $tests = array_values($tests);
        $count = count($tests);

        foreach ($tests as $index => $data) {
            $key = (string) ($data['key'] ?? 'q'.($index + 1));
            $keys[] = $key;
            $this->upsertQuestion($topic, $key, QuestionRole::Test, $data, "$file#$key", [
                'sort' => $data['sort'] ?? $index + 1,
                'segment' => null,
                // Adaptive ramp: unless authored, the first third is easy, the last third hard.
                'difficulty' => $data['difficulty'] ?? min(3, (int) floor($index * 3 / max($count, 1)) + 1),
            ]);
        }

        foreach ($checks as $index => $data) {
            $key = 'c'.($index + 1);
            $keys[] = $key;
            $this->upsertQuestion($topic, $key, QuestionRole::Check, $data, "{$topic->slug}.md check #".($index + 1), [
                'sort' => $index + 1,
                'segment' => $index + 1,
                'difficulty' => $data['difficulty'] ?? 1,
            ]);
        }

        $topic->questions()->whereNotIn('key', $keys)->delete();
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array{sort: int, segment: int|null, difficulty: int}  $placement
     */
    private function upsertQuestion(Topic $topic, string $key, QuestionRole $role, array $data, string $where, array $placement): void
    {
        $type = QuestionType::from($data['type']);
        $this->validateQuestion($type, $data, $where);

        Question::updateOrCreate(
            ['topic_id' => $topic->id, 'key' => $key],
            [
                'role' => $role,
                'type' => $type,
                'prompt' => $data['prompt'],
                'options' => $data['options'] ?? null,
                'answer' => $data['answer'],
                'explanation' => $data['explanation'] ?? null,
                'points' => $data['points'] ?? 1,
                ...$placement,
            ],
        );
        $this->stats['questions']++;
    }

    /**
     * Pull "::: check" fences out of the explanation and leave numbered markers behind.
     *
     * @return array{0: string, 1: array<int, array<string, mixed>>}
     */
    private function extractChecks(string $explanation): array
    {
        $checks = [];
        $n = 0;

        $stripped = preg_replace_callback('/^::: ?check\s*\n(.*?)\n:::\s*$/ms', function (array $m) use (&$checks, &$n) {
            $n++;
            $data = Yaml::parse($m[1]);
            $checks[] = is_array($data) ? $data : [];

            return "<!-- check:$n -->";
        }, $explanation);

        return [trim($stripped ?? $explanation), $checks];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validateQuestion(QuestionType $type, array $data, string $where): void
    {
        $answer = $data['answer'] ?? null;

        $ok = match ($type) {
            QuestionType::SingleChoice => is_array($data['options'] ?? null) && isset($answer['index']) && isset($data['options'][$answer['index']]),
            QuestionType::MultipleChoice => is_array($data['options'] ?? null) && is_array($answer['indexes'] ?? null),
            QuestionType::TrueFalse => is_bool($answer['value'] ?? null),
            QuestionType::Numeric => isset($answer['value']) || is_array($answer['values'] ?? null),
            QuestionType::GapText => is_array($answer['gaps'] ?? null)
                && substr_count($data['prompt'], '___') === count($answer['gaps']),
        };

        if (! $ok) {
            throw new RuntimeException("Ungültige Frage ({$type->value}) in $where");
        }
    }

    /**
     * @return array{0: array<string, mixed>, 1: string}
     */
    private function parseMarkdown(string $raw, string $where): array
    {
        if (preg_match('/\A---\s*\n(.*?)\n---\s*\n(.*)\z/s', $raw, $m) !== 1) {
            throw new RuntimeException("Frontmatter fehlt in $where");
        }

        $frontmatter = Yaml::parse($m[1]);

        if (! is_array($frontmatter) || empty($frontmatter['title'])) {
            throw new RuntimeException("Frontmatter braucht 'title' in $where");
        }

        return [$frontmatter, $m[2]];
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function splitSections(string $body, string $where): array
    {
        $parts = preg_split('/^## Hefteintrag\s*$/m', $body, 2);

        if ($parts === false || count($parts) !== 2) {
            throw new RuntimeException("Abschnitt '## Hefteintrag' fehlt in $where");
        }

        $explanation = preg_replace('/\A\s*## Erklärung\s*$/m', '', $parts[0]) ?? $parts[0];

        return [trim($explanation), trim($parts[1])];
    }

    /**
     * "03-negative-zahlen" → [3, "negative-zahlen"]
     *
     * @return array{0: int, 1: string}
     */
    private function splitPrefix(string $name): array
    {
        if (preg_match('/^(\d+)-(.+)$/', $name, $m) === 1) {
            return [(int) $m[1], Str::slug($m[2])];
        }

        return [0, Str::slug($name)];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function yamlList(string $file): array
    {
        $data = Yaml::parseFile($file);

        return is_array($data) ? array_values(array_filter($data, is_array(...))) : [];
    }

    /**
     * @return array<string, mixed>
     */
    private function yaml(string $file): array
    {
        $data = Yaml::parseFile($file);

        return is_array($data) ? $data : [];
    }
}
