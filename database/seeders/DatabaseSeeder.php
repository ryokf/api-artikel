<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory(3)->create();

        Article::factory(10)->create();

        Category::create([
            'name' => 'programming',
        ]);
        Category::create([
            'name' => 'lifestyle',
        ]);
        Category::create([
            'name' => 'business',
        ]);
    }
}
