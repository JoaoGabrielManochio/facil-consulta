<?php

namespace Tests\Unit;

use App\Models\Medico;
use App\Models\MedicoPaciente;
use App\Models\Paciente;
use Faker\Generator;
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

    /**
     * Should create a new patient.
     */
    public function test_should_create_patient(): void
    {
        $service = app(PacienteServiceInterface::class);

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'cpf' => $faker->cpf,
            'celular' => $faker->cellphone
        ];

        $response = $service->storePatient($input);

        $this->assertNotNull($response);
        $this->assertEquals($input['nome'], $response->nome);
        $this->assertEquals($input['cpf'], $response->cpf);
        $this->assertInstanceOf(Paciente::class, $response);
    }

    /**
     * Should not create a new patient with missing fields.
     */
    public function test_should_not_create_patient_with_missing_fields(): void
    {
        $service = app(PacienteServiceInterface::class);

        $faker = app(Generator::class);

        // missing nome
        $input = [
            'cpf' => $faker->cpf,
            'celular' => $faker->cellphone
        ];

        $response = $service->storePatient($input);

        $this->assertNull($response);

        // missing cpf
        $input = [
            'nome' => $faker->name,
            'celular' => $faker->cellphone
        ];

        $response = $service->storePatient($input);

        $this->assertNull($response);

        // missing celular
        $input = [
            'nome' => $faker->name,
            'cpf' => $faker->cpf,
        ];

        $response = $service->storePatient($input);

        $this->assertNull($response);
    }

    /**
     * Should not create a new patient with with existent cpf.
     */
    public function test_should_not_create_patient_with_existent_cpf(): void
    {
        $service = app(PacienteServiceInterface::class);

        $patient = Paciente::factory()->create();

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'cpf' => $patient->cpf,
            'celular' => $faker->cellphone
        ];

        $response = $service->storePatient($input);

        $this->assertNull($response);
    }

    /**
     * Should not create a new patient with with invalid cpf.
     */
    public function test_should_not_create_patient_with_invalid_cpf(): void
    {
        $service = app(PacienteServiceInterface::class);

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'cpf' => '999.999.999-99',
            'celular' => $faker->cellphone
        ];

        $response = $service->storePatient($input);

        $this->assertNull($response);
    }
}
