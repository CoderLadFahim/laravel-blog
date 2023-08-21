<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = Comment::factory()->count(25)->create();

        foreach ($comments as $comment) {
            $comment->parent_id = rand(0, 100) > 50 ? Comment::inRandomOrder()->first()->id : null;
            $comment->save();
        }
    }
}
