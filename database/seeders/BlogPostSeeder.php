<?php

namespace Database\Seeders;

use App\Models\Blogpost;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogpostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $number_of_blogposts_to_create = 50;
        $blogposts = Blogpost::factory()->count(10)->create();
        $tag = Tag::query()->get()->random(10)->pluck('id')->toArray();


        // for ($i = 0; $i < $number_of_blogposts_to_create; $i++) {
        //     $blogpost = Blogpost::inRandomOrder()->first();
        //     $blogpost->tags()->attach($tag);
        // }


        foreach ($blogposts as $blogpost) {
            $blogpost = Blogpost::inRandomOrder()->first();
            $blogpost->tags()->attach($tag);
        }
    }
}
