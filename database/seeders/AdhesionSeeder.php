<?php

namespace Database\Seeders;

use App\Models\Adhesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdhesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Adhesion::factory()->count(10)->create();
    }
}
