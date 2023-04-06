<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Frequency;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $frequensy = [
            'everyMinute', 'everyFiveMinutes', 'everyTenMinutes', 'everyThirtyMinutes',
            'hourly', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly',
        ];
        foreach ($frequensy as $item) {
            $data = ['title' => $item];
            Frequency::create($data);
        }

        Website::factory(20)->create();
    }
}
