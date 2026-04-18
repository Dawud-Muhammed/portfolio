<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('layouts.app');
    }

    public function store()
    {
        return redirect()->route('home');
    }

    public function show(string $contact): View
    {
        return view('layouts.app');
    }
}
