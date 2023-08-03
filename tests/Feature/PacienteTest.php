<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\MedicoPaciente;
use App\Models\Paciente;
use App\Models\User;
use Faker\Generator;
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

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('GET', route('medicos.listPacientDoctor', $doctor->id), [], $headers);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should not return a list of doctor's patient
     */
    public function test_should_not_return_doctor_patient(): void
    {
        $doctor = Medico::factory()->create();

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('GET', route('medicos.listPacientDoctor', $doctor->id), [], $headers);

        $response->assertStatus(200);
        $this->assertEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should store a new patient
     */
    public function test_should_create_patient(): void
    {
        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'cpf' => $faker->cpf,
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(201);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($input['cpf'], $response['cpf']);
        $this->assertEquals($input['nome'], $response['nome']);
    }

    /**
     * Should not create a new patient with missing fields
     */
    public function test_should_not_create_patient_with_missing_fields(): void
    {
        $faker = app(Generator::class);

        // Missing nome
        $input = [
            'cpf' => $faker->cpf,
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('The nome field is required.', $response['message']);

        // Missing cpf
        $input = [
            'nome' => $faker->name,
            'celular' => $faker->cellphone
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('The cpf field is required.', $response['message']);

        // Missing celular
        $input = [
            'nome' => $faker->name,
            'cpf' => $faker->cpf,
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('The celular field is required.', $response['message']);
    }

    /**
     * Should not create a new patient with existent cpf
     */
    public function test_should_not_create_patient_with_existent_cpf(): void
    {
        $faker = app(Generator::class);

        $patient = Paciente::factory()->create();

        $input = [
            'nome' => $faker->name,
            'cpf' => $patient->cpf,
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('CPF informado já existente!', $response['message']);
    }

    /**
     * Should not create a new patient with invalid cpf
     */
    public function test_should_not_create_patient_with_invalid_cpf(): void
    {
        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'cpf' => '999.999.999-99',
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'POST',
            route('pacientes.store'),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('O CPF informado não é válido', $response['message']);
    }

    /**
     * Should update a new patient
     */
    public function test_should_update_patient(): void
    {
        $patient = Paciente::factory()->create();

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'PUT',
            route('pacientes.update', $patient->id),
            $input,
            $headers
        );

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($input['nome'], $response['nome']);
    }

    /**
     * Should not update patient with missing fields
     */
    public function test_should_not_update_patient_with_missing_fields(): void
    {
        $patient = Paciente::factory()->create();

        $faker = app(Generator::class);

        // Missing nome
        $input = [
            'celular' => $faker->cellphone
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json(
            'PUT',
            route('pacientes.update', $patient->id),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('The nome field is required.', $response['message']);

        // Missing celular
        $input = [
            'nome' => $faker->name,
            'cpf' => $faker->cpf,
        ];
        $response = $this->json(
            'PUT',
            route('pacientes.update', $patient->id),
            $input,
            $headers
        );

        $response->assertStatus(422);
        $this->assertEquals('The celular field is required.', $response['message']);
    }

    /**
     * Get login token
     */
    private function getToken(): string
    {
        $user = User::factory()->create();

        $params = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->json('POST', route('auth.login'), $params);

        return $response['access_token'];
    }
}
