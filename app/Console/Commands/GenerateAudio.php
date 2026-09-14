<?php

namespace App\Console\Commands;

use App\Models\Topic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

/**
 * Turns the narration scripts (database/content/…/<topic>.sprechtext.txt) into MP3s
 * via ElevenLabs and drops them where Topic::audioUrl() expects them.
 */
class GenerateAudio extends Command
{
    protected $signature = 'audio:generate
        {topic? : Slug des Themas (z. B. negative-zahlen); ohne Angabe: alle Themen ohne MP3}
        {--force : Vorhandene MP3s überschreiben}
        {--dry-run : Nur zeigen, was erzeugt würde (inkl. Zeichenanzahl)}';

    protected $description = 'Erzeugt die Vorlese-MP3s der Erklärtexte mit ElevenLabs';

    public function handle(): int
    {
        $key = config('services.elevenlabs.key');
        $voice = config('services.elevenlabs.voice_id');

        if (! $key || ! $voice) {
            $this->error('ELEVENLABS_API_KEY und ELEVENLABS_VOICE_ID müssen in der .env stehen.');

            return self::FAILURE;
        }

        $topics = Topic::query()->with('topicArea.subject')->orderBy('topic_area_id')->orderBy('sort')->get();

        if ($slug = $this->argument('topic')) {
            $topics = $topics->where('slug', $slug);
        }

        $done = 0;
        $chars = 0;

        foreach ($topics as $topic) {
            $script = $this->scriptPath($topic);
            $target = public_path(sprintf('audio/%s/%s/%s.mp3', $topic->topicArea->subject->slug, $topic->topicArea->slug, $topic->slug));
            $label = sprintf('%d.%d %s', $topic->topicArea->sort, $topic->sort, $topic->title);

            if ($script === null) {
                $this->line("<comment>übersprungen</comment> $label – kein Sprechtext");

                continue;
            }

            if (File::exists($target) && ! $this->option('force')) {
                $this->line("<info>vorhanden</info>    $label");

                continue;
            }

            $text = trim(File::get($script));
            $chars += mb_strlen($text);

            if ($this->option('dry-run')) {
                $this->line(sprintf('<comment>würde erzeugen</comment> %s (%s Zeichen)', $label, number_format(mb_strlen($text), 0, ',', '.')));

                continue;
            }

            $this->line("<comment>erzeuge</comment>     $label …");

            $response = Http::withHeaders(['xi-api-key' => $key, 'Accept' => 'audio/mpeg'])
                ->timeout(300)
                ->post("https://api.elevenlabs.io/v1/text-to-speech/{$voice}", [
                    'text' => $text,
                    'model_id' => config('services.elevenlabs.model_id'),
                    'voice_settings' => ['stability' => 0.5, 'similarity_boost' => 0.75, 'style' => 0.0, 'use_speaker_boost' => true],
                ]);

            if (! $response->successful()) {
                $this->error("Fehler bei $label: HTTP {$response->status()} – ".mb_substr($response->body(), 0, 300));

                return self::FAILURE;
            }

            File::ensureDirectoryExists(dirname($target));
            File::put($target, $response->body());
            chmod($target, 0644);
            $done++;
            $this->line(sprintf('<info>fertig</info>      %s → %s (%s KB)', $label, str_replace(public_path().'/', '', $target), number_format(strlen($response->body()) / 1024, 0, ',', '.')));
        }

        $this->newLine();
        $this->info(sprintf('%d MP3(s) erzeugt, %s Zeichen%s.', $done, number_format($chars, 0, ',', '.'), $this->option('dry-run') ? ' (dry-run)' : ' verbraucht'));

        return self::SUCCESS;
    }

    private function scriptPath(Topic $topic): ?string
    {
        $pattern = database_path(sprintf('content/*/*-%s/*-%s.sprechtext.txt', $topic->topicArea->slug, $topic->slug));
        $matches = glob($pattern) ?: [];

        return $matches[0] ?? null;
    }
}
