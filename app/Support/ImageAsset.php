<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageAsset
{
    private const PUBLIC_DISK = 'public';

    private const STORAGE_PREFIX = '/storage/';

    private const FALLBACK_STORAGE_PATH = 'images/photo-1542831371-29b0f74f9713.jpg';

    private const FALLBACK_PUBLIC_PATH = '/images/fallback-image.svg';

    public static function resolve(?string $value, ?string $fallback = null): string
    {
        $candidate = trim((string) $value);

        if ($candidate !== '') {
            $resolved = static::resolveExisting($candidate);
            if ($resolved !== null) {
                return $resolved;
            }
        }

        $fallbackCandidate = trim((string) $fallback);
        if ($fallbackCandidate !== '') {
            $resolvedFallback = static::resolveExisting($fallbackCandidate);
            if ($resolvedFallback !== null) {
                return $resolvedFallback;
            }
        }

        return static::default();
    }

    public static function resolveNullable(?string $value): ?string
    {
        $candidate = trim((string) $value);
        if ($candidate === '') {
            return null;
        }

        return static::resolveExisting($candidate);
    }

    public static function webpVariant(?string $value): ?string
    {
        $resolved = static::resolveNullable($value);
        if (! is_string($resolved)) {
            return null;
        }

        $parts = parse_url($resolved);
        $path = (string) ($parts['path'] ?? '');

        if (! preg_match('/\.(jpe?g)$/i', $path)) {
            return null;
        }

        $query = isset($parts['query']) ? '?'.$parts['query'] : '';

        if (str_starts_with($path, static::STORAGE_PREFIX)) {
            $relativePath = ltrim(substr($path, strlen(static::STORAGE_PREFIX)), '/');
            $webpRelativePath = preg_replace('/\.(jpe?g)$/i', '.webp', $relativePath) ?? '';

            if ($webpRelativePath !== '' && Storage::disk(static::PUBLIC_DISK)->exists($webpRelativePath)) {
                return Storage::url($webpRelativePath).$query;
            }

            return null;
        }

        $publicPath = public_path(ltrim($path, '/'));
        $webpPath = preg_replace('/\.(jpe?g)$/i', '.webp', $publicPath) ?: '';

        if ($webpPath !== '' && is_file($webpPath)) {
            $webpPublicPath = '/'.ltrim(str_replace(public_path(), '', $webpPath), '/\\');

            return str_replace('\\', '/', $webpPublicPath).$query;
        }

        return null;
    }

    public static function default(): string
    {
        if (Storage::disk(static::PUBLIC_DISK)->exists(static::FALLBACK_STORAGE_PATH)) {
            return Storage::url(static::FALLBACK_STORAGE_PATH);
        }

        return asset(static::FALLBACK_PUBLIC_PATH);
    }

    private static function resolveExisting(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        if (static::isRemoteUrl($value)) {
            return $value;
        }

        $parts = parse_url($value);
        $path = trim((string) ($parts['path'] ?? $value));

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, static::STORAGE_PREFIX)) {
            $relativePath = ltrim(substr($path, strlen(static::STORAGE_PREFIX)), '/');

            if ($relativePath !== '' && Storage::disk(static::PUBLIC_DISK)->exists($relativePath)) {
                return Storage::url($relativePath);
            }

            return null;
        }

        $relativeStoragePath = ltrim($path, '/');

        if (str_starts_with($relativeStoragePath, 'storage/')) {
            $diskPath = ltrim(substr($relativeStoragePath, strlen('storage/')), '/');
            if ($diskPath !== '' && Storage::disk(static::PUBLIC_DISK)->exists($diskPath)) {
                return Storage::url($diskPath);
            }
        }

        if (Storage::disk(static::PUBLIC_DISK)->exists($relativeStoragePath)) {
            return Storage::url($relativeStoragePath);
        }

        $publicFile = public_path(ltrim($path, '/'));
        if (is_file($publicFile)) {
            return '/'.ltrim(str_replace('\\', '/', str_replace(public_path(), '', $publicFile)), '/');
        }

        return null;
    }

    private static function isRemoteUrl(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }
}
