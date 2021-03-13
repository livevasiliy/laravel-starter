<?php

namespace App\Domains\Authentication\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class RevokeAllAuthenticationTokensJob extends Job
{
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->tokens()->delete();
    }
}
