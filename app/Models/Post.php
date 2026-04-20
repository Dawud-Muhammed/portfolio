<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HtmlString;
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
    ];

    public function getRenderedBodyAttribute(): HtmlString
    {
        $converter = static::$markdownConverter ??= new CommonMarkConverter();

        return new HtmlString((string) $converter->convert($this->body ?? ''));
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->orderBy('name');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
