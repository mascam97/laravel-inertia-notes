<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = config('admin.name');
        $admin->email = config('admin.email');
        $admin->password = Hash::make(config('admin.password'));
        $admin->save();

        if (! App::environment('production')) {
            User::factory(9)->create();

            /** @var Collection $usersId */
            $usersId = User::query()
                ->whereNot('id', $admin->getKey())
                ->select('id')
                ->get()
                ->pluck('id');

            Note::factory(200)->create(['user_id' => $usersId->random()]);
        }
    }
}
