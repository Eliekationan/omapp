<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Contribution::factory()->count(10)->create();
    }
}
