<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = BlogPost::all();
        $cmnts = (int)$this->command->ask('wel comments 9adeh t7eb ygenerati?');
        $comments = Comments::factory($cmnts)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
