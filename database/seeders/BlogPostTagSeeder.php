<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsCount = Tags::all()->count();
        if ($tagsCount === 0) {
            $this->command->info('There is no tags in here , skipping assigning Tags to BlogPosts');
            return;
        }
        $howManyMin = (int)$this->command->ask('Minimum Tags to be assigned to a BlogPost?' , 0);
        $howManyMax = min((int)$this->command->ask('Maximum Tags to be assigned to a BlogPost?' , $tagsCount) ,$tagsCount);

        BlogPost::all()->each(function (BlogPost $post) use ($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tags::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });


    }
}
