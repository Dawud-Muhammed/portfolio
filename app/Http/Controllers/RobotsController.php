<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function show(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Sitemap: '.url('/sitemap.xml'),
        ])."\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
