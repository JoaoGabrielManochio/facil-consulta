<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::factory()->count(20)->create();
    }
}
