<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Domains\Authentication\Jobs\SetNewPasswordJob;

class SetNewPasswordJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_new_password_job()
    {
        $user = User::factory()->create();
        $password = Str::random();
        $hashedPassword = Hash::make($password);
        $job = new SetNewPasswordJob($user, $hashedPassword);
        $job->handle();
        $isMatch = Hash::check($password, $hashedPassword);
        $this->assertTrue($isMatch);
    }
}
