<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'level' => 'admin',
            'is_active' => true
        ]);

        WebSetting::factory()->create([
            'name' => 'Registrasi Pembimbing Industri',
            'is_enable' => true
        ]);

        WebSetting::factory()->create([
            'name' => 'Periode Penilaian',
            'is_enable' => true
        ]);
    }
}
