<?php

namespace App\Domains\Authentication\Jobs;

use Illuminate\Support\Facades\Hash;
use Lucid\Units\Job;

class MakeHashPasswordJob extends Job
{
    private string $password;

    /**
     * Create a new job instance.
     *
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        return Hash::make($this->password);
    }
}
