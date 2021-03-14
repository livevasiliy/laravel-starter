<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Domains\Authentication\Jobs\LogoutCurrentUserJob;

class LogoutCurrentUserJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_current_user_job()
    {
        $this->markTestIncomplete();
    }
}
