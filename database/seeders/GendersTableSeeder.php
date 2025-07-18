<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genders')->insert([
            [
                'name_en' => 'Male',
                'name_de' => 'Männlich',
                'name_tr' => 'Erkek',
                'description_en' => 'Mr.',
                'description_de' => 'Herr',
                'description_tr' => 'Bay',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Female',
                'name_de' => 'Weiblich',
                'name_tr' => 'Kadın',
                'description_en' => 'Ms.',
                'description_de' => 'Frau',
                'description_tr' => 'Bayan',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Other',
                'name_de' => 'Divers',
                'name_tr' => 'Diğer',
                'description_en' => 'Other',
                'description_de' => 'Divers',
                'description_tr' => 'Diğer',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
