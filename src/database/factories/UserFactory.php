<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create('uk_UA');
        $position = Position::all()->random();

        $imageUrl = 'https://random.imagecdn.app/70/70';

        $imaeName = time() . '.jpg';
        $imgPath = public_path() . '/media/' . $imaeName;
        file_put_contents($imgPath, file_get_contents($imageUrl));

        return [
            'name' => $faker->name,
            'phone' => $faker->phoneNumber,
            'photo' => "/media/$imaeName",
            'position_id' => $position->id,
            'position' => $position->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
