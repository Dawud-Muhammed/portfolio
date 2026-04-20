<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'details',
        'stack',
        'filters',
        'image',
        'github_url',
        'demo_url',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'stack' => 'array',
        'filters' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getOgImageAttribute(): string
    {
        $path = 'og/project-'.$this->getKey().'.jpg';

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return (string) ($this->image ?: config('seo.default_image', ''));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
