<?php

namespace App\Domains\Authentication\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;

class CreateUserJob extends Job
{
    private string $email;

    private string $name;

    private string $password;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function __construct(string $email, string $name, string $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return User
     */
    public function handle(): User
    {
        $attributes = [
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password
        ];

        return User::create($attributes);
    }
}
