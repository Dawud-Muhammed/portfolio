<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $projectTotal = Project::query()->count();
        $projectPublished = Project::query()->published()->count();

        $postTotal = Post::query()->count();
        $postPublished = Post::query()->published()->count();

        return view('admin.dashboard', [
            'projectCount' => $projectTotal,
            'projectPublishedCount' => $projectPublished,
            'postCount' => $postTotal,
            'postPublishedCount' => $postPublished,
            'unreadContactCount' => Contact::query()->whereNull('read_at')->count(),
            'recentContacts' => Contact::query()
                ->latest()
                ->take(5)
                ->get(),
            'recentPosts' => Post::query()
                ->latest('published_at')
                ->latest('id')
                ->take(5)
                ->get(),
            'recentProjects' => Project::query()
                ->latest('published_at')
                ->latest('id')
                ->take(5)
                ->get(),
        ]);
    }
}
