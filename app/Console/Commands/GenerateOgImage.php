<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use RuntimeException;

class GenerateOgImage extends Command
{
    protected $signature = 'og:generate {type : The content type (post or project)} {id : The model ID}';

    protected $description = 'Generate a branded Open Graph image for a blog post or project.';

    public function handle(): int
    {
        $type = strtolower((string) $this->argument('type'));
        $id = (int) $this->argument('id');

        [$title, $subtitle, $outputPath] = $this->resolvePayload($type, $id);

        if ($title === null || $subtitle === null || $outputPath === null) {
            $this->error('Unable to resolve the requested model.');

            return self::FAILURE;
        }

        $siteName = (string) config('seo.default_name', config('app.name', 'Portfolio'));
        $siteTagline = (string) config('seo.job_title', 'Laravel Developer');

        $tempPayload = tempnam(sys_get_temp_dir(), 'og_');

        if ($tempPayload === false) {
            throw new RuntimeException('Unable to create a temporary OG payload file.');
        }

        $payload = [
            'type' => $type,
            'title' => $title,
            'subtitle' => $subtitle,
            'siteName' => $siteName,
            'siteTagline' => $siteTagline,
            'outputPath' => Storage::disk('public')->path($outputPath),
        ];

        File::put($tempPayload, json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));

        try {
            $scriptPath = base_path('scripts/generate-og.mjs');

            if (! File::exists($scriptPath)) {
                throw new RuntimeException('The OG screenshot script could not be found.');
            }

            Storage::disk('public')->makeDirectory('og');

            $process = new Process([
                'node',
                $scriptPath,
                $tempPayload,
            ]);
            $process->setWorkingDirectory(base_path());
            $process->setTimeout(180);
            $process->mustRun();
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        } catch (\Throwable $exception) {
            $this->error(trim($exception->getMessage()));

            return self::FAILURE;
        } finally {
            @unlink($tempPayload);
        }

        $this->info('Generated '.$outputPath.'');

        return self::SUCCESS;
    }

    /**
     * @return array{0: ?string, 1: ?string, 2: ?string}
     */
    private function resolvePayload(string $type, int $id): array
    {
        return match ($type) {
            'post' => $this->resolvePost($id),
            'project' => $this->resolveProject($id),
            default => [null, null, null],
        };
    }

    /**
     * @return array{0: ?string, 1: ?string, 2: ?string}
     */
    private function resolvePost(int $id): array
    {
        $post = Post::query()->find($id);

        if (! $post) {
            return [null, null, null];
        }

        return [
            $post->title,
            $post->excerpt ?: Str::limit(strip_tags((string) $post->body), 140, ''),
            'og/post-'.$post->getKey().'.jpg',
        ];
    }

    /**
     * @return array{0: ?string, 1: ?string, 2: ?string}
     */
    private function resolveProject(int $id): array
    {
        $project = Project::query()->find($id);

        if (! $project) {
            return [null, null, null];
        }

        return [
            $project->title,
            $project->description ?: Str::limit(strip_tags((string) $project->details), 140, ''),
            'og/project-'.$project->getKey().'.jpg',
        ];
    }
}