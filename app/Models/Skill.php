<?php

namespace App\Models;

use App\Enums\SkillCategory;
use App\Enums\SkillProficiency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'skill_id',
        'name',
        'proficiency',
        'years',
        'description',
        'category',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'proficiency' => SkillProficiency::class,
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
