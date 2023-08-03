<?php

namespace Tests\Unit;

use App\Services\Interfaces\LogErrorServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogErrorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should store log error.
     */
    public function test_should_create_log_error(): void
    {
        $service = app(LogErrorServiceInterface::class);

        $params = [
            'error' => 'teste',
            'route' => 'teste123'
        ];

        $service->storeLog($params);

        $this->assertDatabaseHas('log_errors', $params);
    }
}
