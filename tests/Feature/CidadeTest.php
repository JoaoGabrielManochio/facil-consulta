<?php

namespace Tests\Feature;

use App\Models\Cidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CidadeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of citys
     */
    public function test_should_return_city(): void
    {
        Cidade::factory()->count(2)->create();

        $response = $this->json('GET', route('cidades.list'));

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should not return a list of citys
     */
    public function test_should_not_return_city(): void
    {
        $response = $this->json('GET', route('cidades.list'));

        $response->assertStatus(200);
        $this->assertEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }
}
