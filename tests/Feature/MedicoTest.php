<?php

namespace Tests\Feature;

use App\Models\Medico;
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
}
