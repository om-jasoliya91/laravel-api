<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=1; $i<=10; $i++){
            Post::create([
                'title'=>"Post $i",
                'content'=>"This is content for post $i"
            ]);
        }
    }
}
