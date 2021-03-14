<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use App\Domains\Authentication\Jobs\GenerateNewPasswordJob;
use Tests\TestCase;

class GenerateNewPasswordJobTest extends TestCase
{
    public function test_generate_new_password_job()
    {
        $job = new GenerateNewPasswordJob();
        $randomPassword = $job->handle();
        $this->assertIsString($randomPassword);
        $this->assertLessThanOrEqual(16, $randomPassword);
    }

    public function test_generate_new_password_with_params_job()
    {
        $job = new GenerateNewPasswordJob(8);
        $randomPassword = $job->handle();
        $this->assertIsString($randomPassword);
        $this->assertLessThan(16, $randomPassword);
    }
}
