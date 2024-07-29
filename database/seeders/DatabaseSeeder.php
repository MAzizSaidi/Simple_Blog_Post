<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::forget('');

        $this->call([
                UserTableSeeder::class,
                BlogPostsTableSeeder::class,
                CommentsTableSeeder::class
        ]);
        $this->command->info('Database seeded successfully');

    }
}
