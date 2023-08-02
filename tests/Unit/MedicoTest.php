<?php

namespace Tests\Unit;

use App\Models\Cidade;
use App\Models\Medico;
use App\Services\Interfaces\MedicoServiceInterface;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of doctors.
     */
    public function test_should_return_doctor(): void
    {
        $doctors = Medico::factory()->count(1)->create();

        $serviceDoctor = app(MedicoServiceInterface::class);

        $response = $serviceDoctor->listDoctors();

        $this->assertNotEmpty($response);
        $this->assertEquals($doctors[0]->id, $response[0]->id);
        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * Should not return a list of doctors.
     */
    public function test_should_not_return_doctor(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $response = $serviceDoctor->listDoctors();

        $this->assertEmpty($response);
        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * Should create a new doctor.
     */
    public function test_should_create_doctor(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNotNull($response);
        $this->assertEquals($input['nome'], $response->nome);
        $this->assertInstanceOf(Medico::class, $response);
    }

    /**
     * Should not create a new doctor with missing fields.
     */
    public function test_should_not_create_doctor_with_missing_fields(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $faker = app(Generator::class);

        // missing nome
        $input = [
            'especialidade' => 'Teste',
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNull($response);

        // missing especialidade
        $input = [
            'nome' => $faker->name,
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNull($response);

        // missing cidade_id
        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNull($response);
    }

    /**
     * Should not create a new doctor with same nome and especialidade
     */
    public function test_should_not_create_doctor_with_same_nome_and_especialidade(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $doctor = Medico::factory()->create();

        $input = [
            'nome' => $doctor->nome,
            'especialidade' => $doctor->especialidade,
            'cidade_id' => Cidade::factory()->create()->id
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNull($response);
    }

    /**
     * Should not create a new doctor with nonexistent cidade_id
     */
    public function test_should_not_create_doctor_with_nonexistent_cidadeId(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $faker = app(Generator::class);

        $input = [
            'nome' => $faker->name,
            'especialidade' => 'Teste',
            'cidade_id' => 99999999999999
        ];

        $response = $serviceDoctor->storeDoctor($input);

        $this->assertNull($response);
    }

    /**
     * Should return a list of doctors by cidade_id.
     */
    public function test_should_return_doctor_by_cidade_id(): void
    {
        $city = Cidade::factory()->create();

        $doctors = Medico::factory()->count(2)->create(
            [
                'cidade_id' => $city->id
            ]
        );

        $serviceDoctor = app(MedicoServiceInterface::class);

        $params = [
            'cidade_id' => $city->id
        ];

        $response = $serviceDoctor->listDoctors($params);

        $this->assertNotEmpty($response);
        $this->assertEquals($doctors[0]->id, $response[0]->id);
        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * Should not return a list of doctors by cidade_id.
     */
    public function test_should_not_return_doctor_by_cidade_id(): void
    {
        Medico::factory()->count(2)->create();

        $serviceDoctor = app(MedicoServiceInterface::class);

        $params = [
            'cidade_id' => 9999999999
        ];

        $response = $serviceDoctor->listDoctors($params);

        $this->assertEmpty($response);
        $this->assertInstanceOf(Collection::class, $response);
    }
}
