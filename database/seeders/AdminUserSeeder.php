<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'super@admin.com')->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'super@admin.com',
                'password' => Hash::make('ichmagmittwochs'),
            ]);
        }
    }
}
