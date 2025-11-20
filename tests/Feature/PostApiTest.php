<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

use function pest\Laravel\getJson;

class PostApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        static $migrated = false;

        // Migrate only once (keeps data across tests)
        if (!$migrated) {
            $this->artisan('migrate:fresh');
            $migrated = true;
        }
    }

    public function test_it_can_list_posts()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    // test('it can list posts',function(){
    //     Post::factory()->count(3)->create();

    //     $response = $this->getJson('/api/posts');

    //     $response->assertStatus(200)
    //              ->assertJsonCount(3, 'data');
    // });

    public function test_create_post()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Test Title',
            'content' => 'This is content',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Test Title']);
    }

    public function test_it_can_show_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    public function test_it_can_update_a_post()
    {
        $post = Post::factory()->create();

        $data = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/posts/{$post->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_it_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response
            ->assertStatus(204);
            // ->assertJsonFragment(['message' => 'Post deleted successfully.']);
    }

    public function test_console_command(): void
    {
        $this->artisan('inspire')->assertExitCode(0);
    }
}
