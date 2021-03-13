<?php

namespace App\Domains\Authentication\Jobs;

use Illuminate\Support\Str;
use Lucid\Units\Job;

class GenerateNewPasswordJob extends Job
{
    private int $length;

    /**
     * Create a new job instance.
     *
     * @param int $length
     */
    public function __construct(int $length = 16)
    {
        $this->length = $length;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        return Str::random($this->length);
    }
}
