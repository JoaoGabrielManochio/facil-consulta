<?php

namespace Database\Factories;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialty = ['Dermatologia', 'Neurologia', 'Oftalmologia', 'Gastroenterologia', 'Cardiologia'];
        $randKeys = array_rand($specialty, 1);

        return [
            'nome' => fake()->name,
            'especialidade' => $specialty[$randKeys],
            'cidade_id' => Cidade::factory()->create()->id
        ];
    }
}
