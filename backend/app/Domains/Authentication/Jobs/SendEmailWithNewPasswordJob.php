<?php

namespace App\Domains\Authentication\Jobs;

use App\Mail\RecoveryPasswordMail;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Mail;
use Lucid\Units\Job;

class SendEmailWithNewPasswordJob extends Job implements ShouldBeUnique
{
    private string $email;
    private string $password;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(RecoveryPasswordMail::class, [
            'password' => $this->password,
            'email' => $this->email
        ]);
    }
}
