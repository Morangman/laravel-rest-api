<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // get all positions from config
        $positions = Config::get('positions');

        // clear positions table
        \App\Models\Position::query()->truncate();

        // store positions
        foreach ($positions as $position) {
            \App\Models\Position::query()->create([
                'name' => $position,
            ]);
        }

        // clear users table
        \App\Models\User::query()->truncate();

        // store users
        \App\Models\User::factory(45)->create();
    }
}
