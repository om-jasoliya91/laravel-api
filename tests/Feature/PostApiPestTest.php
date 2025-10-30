    <?php

    use App\Models\Post;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;
    use function pest\Laravel\getJson;

    // uses( RefreshDatabase::class,TestCase::class);
    uses(TestCase::class);


    test('it can list posts', function () {
        // Create 3 fake posts
        Post::factory()->count(3)->create();

        // Send request
        $response = $this->getJson('/api/posts');

        // Assert the response
        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    });
