<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Blogpost;
use App\Models\Comment;
use App\Models\GroupMembers;
use App\Models\Tag;
use Database\Factories\GroupFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(50)->create();

        $this->call([TagSeeder::class]);
        $this->call([CategorySeeder::class]);
        $this->call([BlogpostSeeder::class]);
        $this->call([CommentsSeeder::class]);

        \App\Models\Group::factory()->count(10)->create();

        // for ($i=0; $i < 10; $i++) {
        //     \App\Models\Like::factory()->create([
        //         'likeable_id' => $i + 1,
        //         'is_liked' => rand(0, 100) > 50,
        //         'likeable_type' => rand(0, 100) > 50 ? Blogpost::class : Comment::class,
        //     ]);
        // }
    }
}
