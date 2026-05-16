<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_shows_published_posts()
    {
        $post = Post::create([
            'title' => 'My Post',
            'slug' => 'my-post',
            'excerpt' => 'Excerpt',
            'body' => 'Body',
            'published_at' => now(),
        ]);

        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertViewIs('blog.index');
        $response->assertViewHas('posts', function ($posts) use ($post) {
            return $posts->contains(function ($p) use ($post) {
                return $p->is($post);
            });
        });
    }

    public function test_blog_show_displays_post_and_related_navigation()
    {
        $post = Post::create([
            'title' => 'Detailed Post',
            'slug' => 'detailed-post',
            'excerpt' => 'Excerpt',
            'body' => 'Body',
            'published_at' => now(),
        ]);

        $response = $this->get(route('blog.show', ['slug' => $post->slug]));

        $response->assertStatus(200);
        $response->assertViewIs('blog.show');
        $response->assertViewHas('post', function ($p) use ($post) {
            return $p->is($post);
        });
    }
}
