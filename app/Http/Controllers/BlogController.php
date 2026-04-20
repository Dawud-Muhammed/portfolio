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
            ->with('categories')
            ->orderByDesc('published_at')
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
        ]);
    }
}
