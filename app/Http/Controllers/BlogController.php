<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with([
                'categories' => fn ($query) => $query->orderBy('name'),
            ])
            ->latest('published_at')
            ->get();

        return view('blog.index', [
            'posts' => $posts,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with('categories')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = Post::query()
            ->published()
            ->with('categories')
            ->whereKeyNot($post->getKey())
            ->whereHas('categories', static function ($query) use ($post): void {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::query()
                ->published()
                ->with('categories')
                ->whereKeyNot($post->getKey())
                ->orderByDesc('published_at')
                ->limit(3)
                ->get();
        }

        $previousPost = Post::query()
            ->published()
            ->where('published_at', '<', $post->published_at)
            ->orderByDesc('published_at')
            ->first();

        $nextPost = Post::query()
            ->published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at')
            ->first();

        return view('blog.show', [
            'post' => $post,
            'previousPost' => $previousPost,
            'nextPost' => $nextPost,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
