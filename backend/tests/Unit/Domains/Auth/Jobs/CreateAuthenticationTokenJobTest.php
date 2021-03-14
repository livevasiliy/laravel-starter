<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAuthenticationTokenJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_authentication_token_job()
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;
        $this->assertIsString($token);
    }
}
