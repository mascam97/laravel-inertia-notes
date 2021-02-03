<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@laravel.com',
            'password' => bcrypt('12345678')
        ]);

        User::factory(9)->create();
        Note::factory(50)->create();
    }
}
