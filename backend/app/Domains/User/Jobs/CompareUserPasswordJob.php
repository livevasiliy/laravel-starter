<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;

class CompareUserPasswordJob extends Job
{
    /**
     * @var User
     */
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
     * @return bool
     */
    public function handle()
    {
        return Hash::check($this->password, $this->user->getAuthPassword());
    }
}
