<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of users.
     */
    public function test_should_return_user(): void
    {
        $users = User::factory()->count(1)->create();

        $serviceUser = app(UserServiceInterface::class);

        $response = $serviceUser->listUsers();

        $this->assertNotEmpty($response);
        $this->assertEquals($users[0]->id, $response[0]->id);
        $this->assertInstanceOf(Collection::class, $response);
    }

    /**
     * Should not return a list of citys.
     */
    public function test_should_not_return_city(): void
    {
        $serviceUser = app(UserServiceInterface::class);

        $response = $serviceUser->listUsers();

        $this->assertEmpty($response);
        $this->assertInstanceOf(Collection::class, $response);
    }
}
