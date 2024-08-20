<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comments;
use App\Models\User;
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
        $users = User::all();

        $cmnts = (int)$this->command->ask('How many comments you want' , 200);
        $comments = Comments::factory($cmnts)->make()->each(function($comment) use ($posts , $users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
