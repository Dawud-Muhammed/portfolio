<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('layouts.app');
    }

    public function create(): View
    {
        return view('layouts.app');
    }

    public function store()
    {
        return redirect()->route('projects.index');
    }

    public function show(string $project): View
    {
        return view('layouts.app');
    }

    public function edit(string $project): View
    {
        return view('layouts.app');
    }

    public function update(string $project)
    {
        return redirect()->route('projects.show', $project);
    }

    public function destroy(string $project)
    {
        return redirect()->route('projects.index');
    }
}
