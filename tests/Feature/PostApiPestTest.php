    <?php

    use App\Models\Post;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    use function Pest\Laravel\{getJson, postJson, putJson, deleteJson};

    // uses(RefreshDatabase::class, TestCase::class);

    uses(TestCase::class);

    // test('debug refresh', function () {
    //     dump(Post::count());
    //     Post::factory()->count(3)->create();
    //     dump(Post::count());
    // });

    test('it can list posts', function () {
        // Create 3 fake posts
        Post::factory()->count(3)->create();

        // Send request
        $response = $this->getJson('/api/posts');

        // Assert the response
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    });

    test('create post', function () {
        $response = $this->postJson('/api/posts', [
            'title' => 'Test Title',
            'content' => 'This is content',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Test Title']);
    });

    test('it can show a post', function () {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ]);
    });

    test('it returns 404 for non-existing post', function () {
        $response = $this->getJson('/api/posts/9999');

        $response->assertStatus(404);
    });

    test('it can update a post', function () {
        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    });

    test('it can delete a post', function () {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    });
