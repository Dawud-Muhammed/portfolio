<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
