<?php

namespace App\Models;

use Database\Factories\TopicAreaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $subject_id
 * @property string $slug
 * @property string $name
 * @property string|null $description
 * @property string|null $curriculum_ref
 * @property int $sort
 */
#[Fillable(['subject_id', 'slug', 'name', 'description', 'curriculum_ref', 'sort'])]
class TopicArea extends Model
{
    /** @use HasFactory<TopicAreaFactory> */
    use HasFactory;

    /** @return BelongsTo<Subject, $this> */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /** @return HasMany<Topic, $this> */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('sort');
    }
}
