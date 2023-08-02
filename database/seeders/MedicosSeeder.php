<?php

namespace Database\Seeders;

use App\Models\Medico;
use Illuminate\Database\Seeder;

class MedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medico::factory()->count(20)->create();
    }
}
