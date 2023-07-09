<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Food;
use App\Models\User;
use App\Models\Review;
use App\Models\FoodTag;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // \App\Models\User::factory()->create([
                //     'name' => 'Test User',
                //     'email' => 'test@example.com',
                // ]);








        User::factory(9)->create();

        User::create([
            'name' => 'pyae sone',
            'email' => 'psn@gmail.com',
            'password' =>Hash::make('admin123'),
            'gender' => null,
            'role' => true,
            'phone' => '123',
            'address' => 'yangon',
            'restrictions'=> 0,
            'allergies'=> 0,
            'preferred_cuisine'=> null,
            'membership'=> 1,
            'userToken' => null,
            'email_verified_at' => now(),
        ]);

        Category::factory()->count(5)->create();

        Food::factory(10)->create();


        Tag::factory()->count(2)->create();

        Tag::create([
            'name' => 'Special'
        ]);
        Tag::create([
            'name' => 'Economic'
        ]);
        Tag::create([
            'name' => 'Popular'
        ]);


        Review::factory(5)->create();



    }
}