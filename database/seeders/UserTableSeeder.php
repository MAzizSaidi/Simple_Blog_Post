<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->aziz()->create();

        $usercount = (int)$this->command->ask('How many user u want', 20);
        User::factory($usercount)->create();

    }
}
