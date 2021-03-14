<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use Illuminate\Support\Str;
use Tests\TestCase;
use App\Domains\Authentication\Jobs\MakeHashPasswordJob;

class MakeHashPasswordJobTest extends TestCase
{
    public function test_make_hash_password_job()
    {
        $password = Str::random();
        $job = new MakeHashPasswordJob($password);
        $hashedPassword = $job->handle();
        $this->assertIsString($hashedPassword);
        $this->assertLessThanOrEqual(60, $hashedPassword);
        $this->assertMatchesRegularExpression('/^\$2y\$/', $hashedPassword);
    }
}
