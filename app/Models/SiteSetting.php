<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @var array<string, string|null>
     */
    protected static array $resolvedValues = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$resolvedValues)) {
            return static::$resolvedValues[$key] ?? $default;
        }

        if (! Schema::hasTable('site_settings')) {
            static::$resolvedValues[$key] = null;

            return $default;
        }

        try {
            $value = static::query()
                ->where('key', $key)
                ->value('value');
        } catch (Throwable) {
            static::$resolvedValues[$key] = null;

            return $default;
        }

        static::$resolvedValues[$key] = $value;

        return $value ?? $default;
    }

    public static function flushResolvedValues(): void
    {
        static::$resolvedValues = [];
    }

    public static function forgetStoredFile(?string $value): void
    {
        $path = static::storedPublicPath($value);

        if ($path === null) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    public static function storedPublicPath(?string $value): ?string
    {
        $candidate = trim((string) $value);

        if ($candidate === '') {
            return null;
        }

        $parts = parse_url($candidate);
        $path = trim((string) ($parts['path'] ?? $candidate));

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, '/storage/')) {
            return ltrim(substr($path, strlen('/storage/')), '/');
        }

        $relativePath = ltrim($path, '/');

        if (str_starts_with($relativePath, 'storage/')) {
            return ltrim(substr($relativePath, strlen('storage/')), '/');
        }

        if (Storage::disk('public')->exists($relativePath)) {
            return $relativePath;
        }

        return null;
    }
}
