<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User();
        $admin->name = config('admin.name');
        $admin->email = config('admin.email');
        $admin->password = Hash::make(config('admin.password'));
        $admin->save();

        if (! App::environment('production')) {
            $premiumSubscription = Subscription::factory()->create([
                'name' => 'Premium subscription',
                'rules' => ['notes_maximum_amount' => null]
            ]);

            $admin->subscription()->associate($premiumSubscription)->save();

            $freeSubscription = Subscription::factory()->create([
                'name' => 'Free subscription',
                'rules' => ['notes_maximum_amount' => 100]
            ]);

            User::factory(100)->create([
                'subscription_id' => $freeSubscription->getKey()
            ]);

            User::query()
                ->select('id')
                ->get()
                ->each(function (User $user) {
                    Note::factory(50)->user($user)->create();
                });
        }
    }
}
