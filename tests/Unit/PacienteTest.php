<?php

namespace Tests\Unit;

use App\Models\Medico;
use App\Models\MedicoPaciente;
use App\Services\Interfaces\PacienteServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of doctor's patient
     */
    public function test_should_return_doctor_patient(): void
    {
        $doctor = Medico::factory()->create();

        MedicoPaciente::factory()->count(2)->create(
            [
                'medico_id' => $doctor->id
            ]
        );

        $serviceDoctor = app(PacienteServiceInterface::class);

        $response = $serviceDoctor->listPatients($doctor->id);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
    }

    /**
     * Should not return a list of doctor's patient
     */
    public function test_should_not_return_doctor_patient(): void
    {
        $doctor = Medico::factory()->create();

        $serviceDoctor = app(PacienteServiceInterface::class);

        $response = $serviceDoctor->listPatients($doctor->id);

        $this->assertEmpty($response);
    }
}
