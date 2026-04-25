<?php

namespace App\Models;

use App\Support\ImageAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;

class Post extends Model
{
    use HasFactory;

    protected static ?CommonMarkConverter $markdownConverter = null;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'published_at',
        'reading_time_minutes',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'reading_time_minutes' => 'integer',
    ];

    protected $appends = [
        'rendered_body',
        'cover_image_url',
        'og_image',
    ];

    public function getRenderedBodyAttribute(): HtmlString
    {
        $converter = static::$markdownConverter ??= new CommonMarkConverter();

        $source = (string) ($this->body ?? $this->getAttribute('content') ?? '');

        if (trim($source) === '') {
            $source = (string) ($this->excerpt ?? '');
        }

        return new HtmlString((string) $converter->convert($source));
    }

    public function getOgImageAttribute(): string
    {
        $path = 'og/post-'.$this->getKey().'.jpg';

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return $this->cover_image_url;
    }

    public function getCoverImageUrlAttribute(): string
    {
        return ImageAsset::resolve((string) $this->getRawOriginal('cover_image'), (string) config('seo.default_image', ''));
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->orderBy('name');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }
}
