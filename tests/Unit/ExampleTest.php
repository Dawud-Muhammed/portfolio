<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Support\HtmlString;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function test_rendered_body_returns_html_string()
    {
        $post = new Post([
            'title' => 'Hello',
            'slug' => 'hello',
            'body' => '# Heading',
        ]);

        $rendered = $post->rendered_body;

        $this->assertIsString($rendered);
        $this->assertStringContainsString('<h1', $rendered);
    }
}
