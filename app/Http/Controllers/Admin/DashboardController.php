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
        return view('admin.dashboard', [
            'projectCount' => Project::query()->count(),
            'postCount' => Post::query()->count(),
            'unreadContactCount' => Contact::query()->whereNull('read_at')->count(),
        ]);
    }
}
