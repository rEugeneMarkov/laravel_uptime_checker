<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Website;
use App\Models\CheckError;
use Illuminate\Database\Seeder;
use App\Models\CheckWebsiteData;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        User::factory(4)->create();

        Website::factory(100)->create();
        CheckWebsiteData::factory(1000)->create();
        CheckError::factory(30)->create();
    }
}
