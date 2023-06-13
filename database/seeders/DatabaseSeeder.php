<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        // User::create([
        //     'name' => null,
        //     'email' => 'psn@gmail.com',
        //     'password' =>Hash::make('admin123'),
        //     'gender' => ' ',
        //     'role' => true,
        //     'phone' => '123',
        //     'address' => 'yangon',
        //     'restrictions'=> 0,
        //     'allergies'=> 0,
        //     'preferred_cuisine'=> null,
        //     'membership'=> 1,

        //     'userToken' => null,
        //     'email_verified_at' => now(),
        // ]);

        Category::factory()->count(5)->create();

        Tag::factory()->count(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}