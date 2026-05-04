<?php

namespace App\Models;

use App\Enums\SkillCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_id',
        'name',
        'level',
        'years',
        'description',
        'category',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'level' => 'integer',
        'years' => 'integer',
        'category' => SkillCategory::class,
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
