<?php

namespace App\Models;

use Database\Factories\SubjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string|null $description
 * @property string $icon
 * @property string $color
 * @property int $grade
 * @property string $school_type
 * @property string $state
 * @property string $curriculum_version
 * @property int $sort
 * @property bool $optional
 */
#[Fillable(['slug', 'name', 'description', 'icon', 'color', 'grade', 'school_type', 'state', 'curriculum_version', 'sort', 'optional'])]
class Subject extends Model
{
    /** @use HasFactory<SubjectFactory> */
    use HasFactory;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['optional' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** @return HasMany<TopicArea, $this> */
    public function topicAreas(): HasMany
    {
        return $this->hasMany(TopicArea::class)->orderBy('sort');
    }

    /** @return HasManyThrough<Topic, TopicArea, $this> */
    public function topics(): HasManyThrough
    {
        return $this->hasManyThrough(Topic::class, TopicArea::class);
    }
}
