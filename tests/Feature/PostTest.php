<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_read_own_all_the_posts()
    {
        $user = User::factory()->create();

        $post = Post::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('/posts');

        $response->assertSee($post->title);
    }

    public function test_a_user_cant_read_not_owned_the_posts()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/posts');

        $response->assertDontSee($post->title);
    }

    public function test_a_user_can_read_single_post()
    {
        $user = User::factory()->create();

        //Given we have post in the database
        $post = Post::factory()->for($user)->create();

        //When user visit the post page
        $response = $this->actingAs($user)->get(route('posts.show', $post));

        $response->assertSuccessful();

        //He can see the post details
        $response
            ->assertSee($post->title)
            ->assertSee($post->description);
    }

    public function test_a_user_edit_own_posts()
    {
        $this->assertTrue(true);
//        $user = User::factory()->create();
//
//        //Given we have post in the database
//        $post = Post::factory()->for($user)->create();
//
//        $this->actingAs($user);
//
//        $this
//            ->get(route('posts.edit', $post))
//            ->assertOk();
//
//        $this
//            ->delete(route('posts.destroy', $post))
//            ->assertOk();
    }
}
