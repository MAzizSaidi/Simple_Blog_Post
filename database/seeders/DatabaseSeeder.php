<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Aziz',
            'email' => 'aziz@gmail.com',
            'email_verified_at' =>  now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=> Str::random(10),
        ]);

        if($this->command->confirm('hey 9olli t7eb refresh lel base ?', false)){
            $this->command->call('migrate:refresh');
            $this->command->info('stanna nkamelek el seeding 7obi');
        }
        $this->call([
                UserTableSeeder::class,
                BlogPostsTableSeeder::class,
                CommentsTableSeeder::class
        ]);
        $this->command->info('awka saye a3emil talla 3albase, Sinon ,  kin t7eb na3mlou 9ahwa nfaserlek vue.js <3');

    }
}
