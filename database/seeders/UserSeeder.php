<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(13),
        //     'second_name' => Str::random(13),
        //     'email' => Str::random(13).'@example.com',
        //     'password' => Hash::make('password'),
        // ]);
        User::factory()->count(10)->create();
    }
}