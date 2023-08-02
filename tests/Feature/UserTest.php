<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should return a list of users
     */
    public function test_should_return_user(): void
    {
        User::factory()->count(2)->create();

        $response = $this->json('GET', route('users.list'));

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }

    /**
     * Should not return a list of users
     */
    public function test_should_not_return_user(): void
    {
        $response = $this->json('GET', route('users.list'));

        $response->assertStatus(200);
        $this->assertEmpty($response->getData());
        $this->assertIsArray($response->getData());
    }
}
