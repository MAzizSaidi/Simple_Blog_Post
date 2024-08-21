<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Images;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->aziz()->create();

        // Directory containing images
        $directory = public_path('images/profile_pics');

        // Retrieve all filenames from the directory
        $imageFiles = File::files($directory);
        $images = array_map(fn($file) => 'images/profile_pics/' . $file->getFilename(), $imageFiles);

        // Ensure the images array is not empty
        if (empty($images)) {
            $this->command->error('No images available in the directory.');
            return;
        }

        // Ask for the number of users to create
        $userCount = (int)$this->command->ask('How many users do you want?', 20);

        // Create the users and assign random profile pictures
        User::factory($userCount)->create()->each(function ($user) use ($images) {
            // Randomly select an image from the list
            $randomImage = $images[array_rand($images)];

            // Create and assign the image
            $image = Images::create([
                'path' => $randomImage,
                'imageable_id' => $user->id,
                'imageable_type' => User::class,
            ]);

            // Attach the image to the user
            $user->image()->save($image);
        });
    }
}
