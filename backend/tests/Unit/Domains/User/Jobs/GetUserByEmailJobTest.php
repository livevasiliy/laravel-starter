<?php

namespace Tests\Unit\Domains\User\Jobs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Faker\Factory as Fake;
use App\Domains\User\Jobs\GetUserByEmailJob;

class GetUserByEmailJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_by_email_job()
    {
        $faker = Fake::create();

        User::create([
            'name' => $faker->name,
            'email' => 'tester@test.ru',
            'password' => Hash::make('password')
        ]);

        $job = new GetUserByEmailJob('tester@test.ru');
        $fetchedUser = $job->handle();
        $this->assertDatabaseHas('users', [
            'email' => 'tester@test.ru'
        ]);
        $this->assertInstanceOf(User::class, $fetchedUser);
        $this->assertEquals('tester@test.ru', $fetchedUser->email);
    }
}
