<?php

namespace Tests\Unit;

use App\Models\Cidade;
use App\Services\Interfaces\CidadeServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CidadeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of citys.
     */
    public function test_should_return_city(): void
    {
        $citys = Cidade::factory()->count(1)->create();

        $serviceCity = app(CidadeServiceInterface::class);

        $response = $serviceCity->listCitys();

        $this->assertNotEmpty($response);
        $this->assertEquals($citys[0]->id, $response[0]->id);
        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * Should not return a list of citys.
     */
    public function test_should_not_return_city(): void
    {
        $serviceCity = app(CidadeServiceInterface::class);

        $response = $serviceCity->listCitys();

        $this->assertEmpty($response);
        $this->assertInstanceOf(Collection::class, $response);
    }
}
