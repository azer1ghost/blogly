<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_will_be_successfully_redirect_to_articles_page()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_guest_can_view_articles_page()
    {
        $response = $this->get('/articles');

        $response->assertSuccessful();
    }

    public function test_guest_can_get_cached_articles_page()
    {
        $response = $this->post('/articles');

        $response->assertJsonStructure([
            'current',
            'posts' => [
                '*' => [
                    'id',
                    'slug',
                    'title',
                    'author',
                    'description',
                    'publication_date'
                ]
            ]
        ]);
    }

    public function test_guest_can_view_article_detail_page()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('article', $post));

        $response->assertSuccessful();

        $response->assertSee($post->title);
    }
}
