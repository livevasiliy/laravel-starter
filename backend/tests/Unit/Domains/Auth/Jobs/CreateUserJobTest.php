<?php

namespace Tests\Unit\Domains\Auth\Jobs;

use App\Domains\Authentication\Jobs\GenerateNewPasswordJob;
use App\Domains\Authentication\Jobs\MakeHashPasswordJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Fake;

class CreateUserJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_job()
    {
        $faker = Fake::create();

        $generateRandomPasswordJob = new GenerateNewPasswordJob();
        $password = $generateRandomPasswordJob->handle();

        $this->assertIsString($password);
        $this->assertLessThanOrEqual(16, $password);

        $makeHashPasswordJob = new MakeHashPasswordJob($password);
        $hashedPassword = $makeHashPasswordJob->handle();

        $this->assertIsString($hashedPassword);

        $attributes = [
            'name' => 'tester',
            'email' => 'tester@test.ru',
            'password' => $hashedPassword
        ];

        $user = User::create($attributes);
        $this->assertDatabaseCount('users', 1);
        $this->assertIsObject($user);
        $this->assertDatabaseHas('users', [
            'name' => 'tester',
            'email' => 'tester@test.ru'
        ]);
    }
}
