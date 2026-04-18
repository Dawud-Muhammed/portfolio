<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function show(): Response
    {
        $xml = Cache::remember('seo:sitemap:xml', now()->addHours(24), function (): string {
            $homeUrl = route('home');

            $projects = Project::query()
                ->published()
                ->orderByDesc('updated_at')
                ->get(['slug', 'updated_at', 'published_at']);

            $posts = Post::query()
                ->published()
                ->orderByDesc('updated_at')
                ->get(['slug', 'updated_at', 'published_at']);

            $homeLastmod = $this->formatDate(
                $projects->pluck('updated_at')->filter()->max()
                    ?? $posts->pluck('updated_at')->filter()->max()
                    ?? now()
            );

            $items = [];
            $items[] = $this->urlNode($homeUrl, $homeLastmod, 'daily', '1.0');

            foreach ($projects as $project) {
                $items[] = $this->urlNode(
                    route('projects.show', $project->slug),
                    $this->formatDate($project->updated_at ?? $project->published_at ?? now()),
                    'weekly',
                    '0.8'
                );
            }

            foreach ($posts as $post) {
                $items[] = $this->urlNode(
                    route('blog.show', $post->slug),
                    $this->formatDate($post->updated_at ?? $post->published_at ?? now()),
                    'weekly',
                    '0.7'
                );
            }

            return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .
                implode('', $items) .
                '</urlset>';
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function urlNode(string $loc, string $lastmod, string $changefreq, string $priority): string
    {
        return '<url>'.
            '<loc>'.e($loc).'</loc>'.
            '<lastmod>'.$lastmod.'</lastmod>'.
            '<changefreq>'.$changefreq.'</changefreq>'.
            '<priority>'.$priority.'</priority>'.
            '</url>';
    }

    private function formatDate(mixed $date): string
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        return now()->format('Y-m-d');
    }
}
