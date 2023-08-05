<?php

namespace Database\Seeders;

use App\Models\Blogpost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogpostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blogpost::factory()->count(10)->create();
    }
}
