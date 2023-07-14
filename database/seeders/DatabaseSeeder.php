<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Links;
use App\Models\LinkVisitLogs;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@lynksun.com',
            'role' => 'admin',
            'password' => Hash::make('admin1234'),
        ]);

        User::factory()->count(73)->create();
        Links::factory()->count(183)->create();
        LinkVisitLogs::factory()->count(7826)->create();
    }
}
