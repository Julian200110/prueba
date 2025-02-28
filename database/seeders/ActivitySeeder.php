<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Activity::factory(5)->create(['user_id' => $user->id]);
        });
    }
}