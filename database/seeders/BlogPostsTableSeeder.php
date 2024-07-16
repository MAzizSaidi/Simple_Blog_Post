<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $blogs = (int)$this->command->ask('ch9awlek fi 50 blogpost bb ? ', 50);
        if($blogs === 0) {
           $this->command->info('akeka la fama la blogpost la comments bb 3awed mil lowel');
           return;
        }

        $posts = BlogPost::factory($blogs)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
