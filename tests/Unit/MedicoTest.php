<?php

namespace Tests\Unit;

use App\Models\Medico;
use App\Services\Interfaces\MedicoServiceInterface;
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
    }

    /**
     * Should not return a list of doctors.
     */
    public function test_should_not_return_doctor(): void
    {
        $serviceDoctor = app(MedicoServiceInterface::class);

        $response = $serviceDoctor->listDoctors();

        $this->assertEmpty($response);
    }
}
