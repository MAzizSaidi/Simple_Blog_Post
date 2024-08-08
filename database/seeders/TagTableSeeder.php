<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding TagTable...');
        $tags = collect([
            'Gaming',
            'Sports',
            'Entertainment',
            'Technology',
            'Music',
            'Movies',
            'Books',
            'Travel',
            'Food',
            'Health'
        ]);
        $tags->each(function ($tagName) {
           $tag = new Tags();
           $tag->name = $tagName;
           $tag->save();
        });

    }
}
