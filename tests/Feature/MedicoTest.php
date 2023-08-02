<?php

namespace Tests\Feature;

use App\Models\Cidade;
use App\Models\Medico;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of doctor
     */
    public function test_should_return_doctor(): void
    {
        Medico::factory()->count(2)->create();

        $response = $this->json('GET', route('medicos.list'));

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should not return a list of doctors
     */
    public function test_should_not_return_doctor(): void
    {
        $response = $this->json('GET', route('medicos.list'));

        $response->assertStatus(200);
        $this->assertEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should create a new doctor
     */
    public function test_should_create_doctor(): void
    {
        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(201);
        $this->assertNotEmpty($response->getData());
        $this->assertEquals($input['nome'], $response['nome']);
    }

    /**
     * Should not create a new doctor with missing fields
     */
    public function test_should_not_create_doctor_with_missing_fields(): void
    {
        $faker = app(Generator::class);

        // Missing nome
        $input = [
            'especialidade' => 'Teste',
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(422);
        $this->assertEquals('The nome field is required.', $response['message']);

        // Missing especialidade
        $input = [
            'nome' => $faker->name,
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(422);
        $this->assertEquals('The especialidade field is required.', $response['message']);

        // Missing cidade_id
        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(422);
        $this->assertEquals('The cidade id field is required.', $response['message']);
    }

    /**
     * Should not create a new doctor with same nome and especialidade
     */
    public function test_should_not_create_doctor_with_same_nome_and_especialidade(): void
    {
        $doctor = Medico::factory()->create();

        $input = [
            'nome' => $doctor->nome,
            'especialidade' => $doctor->especialidade,
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(422);

        $this->assertEquals('Médico informado já existente!', $response['message']);
    }

    /**
     * Should not create a new doctor with nonexistent cidade_id
     */
    public function test_should_not_create_doctor_with_nonexistent_cidadeId(): void
    {
        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
            'cidade_id' => 99999999999999
        ];

        $token = self::getToken();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->json('POST', route('medicos.store'), $input, $headers);

        $response->assertStatus(422);
        $this->assertEquals('O ID informado no cidade_id não existe!', $response['message']);
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
