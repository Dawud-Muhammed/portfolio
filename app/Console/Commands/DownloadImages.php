<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class DownloadImages extends Command
{
    protected $signature = 'app:download-images';

    protected $description = 'Download portfolio images into storage/app/public/images and generate WebP versions.';

    private bool $supportsWebp = false;

    public function handle(): int
    {
        $this->supportsWebp = function_exists('imagecreatefromjpeg') && function_exists('imagewebp');

        if (! $this->supportsWebp) {
            $this->warn('GD with JPEG/WebP support is not available. Downloading JPG files only.');
        }

        $images = [
            'photo-1492144534655-ae79c964c9d7.jpg' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1600&q=80',
            'photo-1517248135467-4c7edcad34c4.jpg' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600&q=80',
            'photo-1560518883-ce09059eeffa.jpg' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1600&q=80',
            'photo-1503676260728-1c00da094a0b.jpg' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1600&q=80',
            'photo-1586528116311-ad8dd3c8310d.jpg' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1600&q=80',
            'photo-1461749280684-dccba630e2f6.jpg' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1600&q=80',
            'photo-1518770660439-4636190af475.jpg' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80',
            'photo-1494790108377-be9c29b29330.jpg' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80',
            'photo-1500648767791-00dcc994a43e.jpg' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80',
            'photo-1438761681033-6461ffad8d80.jpg' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=800&q=80',
            'photo-1506794778202-cad84cf45f1d.jpg' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=800&q=80',
            'photo-1542831371-29b0f74f9713.jpg' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1200&q=80',
            'photo-1484417894907-623942c8ee29.jpg' => 'https://images.unsplash.com/photo-1484417894907-623942c8ee29?auto=format&fit=crop&w=1600&q=80',
            'photo-1555066931-4365d14bab8c.jpg' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1600&q=80',
            'photo-1467232004584-a241de8bcf5d.jpg' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?auto=format&fit=crop&w=1600&q=80',
            'photo-1517180102446-f3ece451e9d8.jpg' => 'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?auto=format&fit=crop&w=1600&q=80',
        ];

        foreach ($images as $filename => $sourceUrl) {
            $this->downloadAndConvert($sourceUrl, $filename);
        }

        $this->info(sprintf('Processed %d images into storage/app/public/images.', count($images)));

        return self::SUCCESS;
    }

    private function downloadAndConvert(string $sourceUrl, string $filename): void
    {
        $directory = 'images';
        $jpegPath = $directory.'/'.$filename;
        $webpPath = $directory.'/'.pathinfo($filename, PATHINFO_FILENAME).'.webp';

        if (! Storage::disk('public')->exists($jpegPath)) {
            $contents = @file_get_contents($sourceUrl);

            if ($contents === false) {
                throw new RuntimeException("Unable to download image: {$sourceUrl}");
            }

            Storage::disk('public')->put($jpegPath, $contents);
        }

        if (! $this->supportsWebp) {
            $this->line(sprintf('%s -> %s', $sourceUrl, Storage::url($jpegPath)));

            return;
        }

        $temporaryJpeg = Storage::disk('public')->path($jpegPath);
        $image = imagecreatefromjpeg($temporaryJpeg);

        if ($image === false) {
            throw new RuntimeException("Unable to create image resource from: {$jpegPath}");
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, 80);
        $webpContents = ob_get_clean();
        imagedestroy($image);

        if ($webpContents === false) {
            throw new RuntimeException("Unable to generate WebP for: {$jpegPath}");
        }

        Storage::disk('public')->put($webpPath, $webpContents);

        $this->line(sprintf('%s -> %s | %s', $sourceUrl, Storage::url($jpegPath), Storage::url($webpPath)));
    }
}
