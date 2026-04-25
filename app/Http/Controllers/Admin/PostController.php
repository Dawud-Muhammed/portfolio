<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminPostRequest;
use App\Http\Requests\Admin\UpdateAdminPostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()->with('categories')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(),
            'categories' => Category::query()->orderBy('name')->get(),
            'mode' => 'create',
        ]);
    }

    public function store(StoreAdminPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image_file')) {
            $path = Storage::disk('public')->put('images', $request->file('cover_image_file'));
            $validated['cover_image'] = Storage::url($path);
        }

        $categoryIds = $validated['categories'] ?? [];

        unset($validated['cover_image_file']);
        unset($validated['categories']);

        $post = Post::query()->create($validated);
        $post->categories()->sync($categoryIds);
        $this->generateOgImage('post', $post->getKey());

        return redirect()->route('admin.posts.index')->with('status', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        $post->loadMissing('categories');

        return view('admin.posts.form', [
            'categories' => Category::query()->orderBy('name')->get(),
            'post' => $post,
            'mode' => 'edit',
        ]);
    }

    public function update(UpdateAdminPostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image_file')) {
            $path = Storage::disk('public')->put('images', $request->file('cover_image_file'));
            $validated['cover_image'] = Storage::url($path);
        }

        $categoryIds = $validated['categories'] ?? [];

        unset($validated['cover_image_file']);
        unset($validated['categories']);

        $post->update($validated);
        $post->categories()->sync($categoryIds);
        $this->generateOgImage('post', $post->getKey());

        return redirect()->route('admin.posts.index')->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted successfully.');
    }

    private function generateOgImage(string $type, int $id): void
    {
        Artisan::call('og:generate', [
            'type' => $type,
            'id' => (string) $id,
        ]);
    }
}
