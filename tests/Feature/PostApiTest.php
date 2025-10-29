<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_list_posts()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /**
     * @test
     */
    public function it_can_create_a_post()
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post content',
        ];

        $response = $this->postJson('/api/posts', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Post']);
    }

    /**
     * @test
     */
    public function it_can_show_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    /**
     * @test
     */
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create();

        $data = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/posts/{$post->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    /**
     * @test
     */
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Post deleted successfully.']);
    }
}
    