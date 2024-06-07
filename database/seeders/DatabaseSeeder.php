<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\Role::factory()->count(2)->create(); // Membuat 2 role
        \App\Models\Status::factory()->count(5)->create(); // Membuat 5 status
        \App\Models\User::factory()->count(10)->create(); // Membuat 10 user
        \App\Models\Aduan::factory()->count(20)->create(); // Membuat 20 aduan
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
