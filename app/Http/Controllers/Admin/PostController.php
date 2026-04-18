<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminPostRequest;
use App\Http\Requests\Admin\UpdateAdminPostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(),
            'mode' => 'create',
        ]);
    }

    public function store(StoreAdminPostRequest $request): RedirectResponse
    {
        Post::query()->create($request->validated());

        return redirect()->route('admin.posts.index')->with('status', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', [
            'post' => $post,
            'mode' => 'edit',
        ]);
    }

    public function update(UpdateAdminPostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return redirect()->route('admin.posts.index')->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted successfully.');
    }
}
