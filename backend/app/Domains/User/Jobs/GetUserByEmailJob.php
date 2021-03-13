<?php

namespace App\Domains\User\Jobs;

use Lucid\Units\Job;
use App\Models\User;

class GetUserByEmailJob extends Job
{
    private string $email;

    /**
     * Create a new job instance.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return null|User
     */
    public function handle()
    {
        return User::where('email', '=', $this->email)->firstOrFail();
    }
}
