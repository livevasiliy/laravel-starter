<?php

namespace App\Domains\Authentication\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class SetNewPasswordJob extends Job
{
    private User $user;
    private string $password;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $password
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->update(['password' => $this->password]);
    }
}
