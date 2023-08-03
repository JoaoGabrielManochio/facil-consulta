<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\MedicoPaciente;
use App\Models\User;
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
