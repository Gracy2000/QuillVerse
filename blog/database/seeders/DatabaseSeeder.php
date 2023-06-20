<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Dipesh',
            'email' => 'dagangwani101@gmail.com',
            'password' => Hash::make('abcd1234'),
            'role' => 'admin',
            'email_verified_at' => Carbon::now()
        ]);
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $categories = ['Sports', 'Technology', 'Gaming'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        $tags = ['Education', 'Coding', 'Computers', 'Softwares', 'Programming'];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

        $this->call([
            BlogsSeeder::class,
            CommentsSeeder::class,
        ]);
    }
}
