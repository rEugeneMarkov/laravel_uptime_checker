<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Website;
use App\Models\Frequency;
use Illuminate\Database\Seeder;
use App\Services\WebsiteCheckServices\WebsiteChecker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        \App\Models\User::factory(5)->create();

        $frequency = [
            'everyMinute', 'everyFiveMinutes', 'everyTenMinutes', 'everyThirtyMinutes',
            'hourly', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly',
        ];
        foreach ($frequency as $item) {
            $data = ['title' => $item];
            Frequency::create($data);
        }

        Website::factory(100)->create();

        $websites = Website::all();
        $checker = new WebsiteChecker();
        foreach ($websites as $website) {
            $checker->checkWebsite($website);
        }
    }
}
