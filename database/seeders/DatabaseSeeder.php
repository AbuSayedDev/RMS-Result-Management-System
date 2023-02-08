<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        // $users = \App\Models\User::all();
        // foreach ($users as $user) {
        //     if ($user->role_id == 1) {
        //         $user->password = Hash::make('admin');
        //         $user->save();
        //     } else if ($user->role_id == 2) {
        //         $user->password = Hash::make('student');
        //         $user->save();
        //     } else if ($user->role_id == 3) {
        //         $user->password = Hash::make('teacher');
        //         $user->save();
        //     }
        // }
        // dd('done');

        // \App\Models\User::factory(100)->create();
    }
}
