<?php

namespace App\Services\Authentication\Operations;

use App\Domains\Authentication\Jobs\MakeHashPasswordJob;
use App\Domains\Authentication\Jobs\RevokeAllAuthenticationTokensJob;
use App\Domains\Authentication\Jobs\SetNewPasswordJob;
use App\Models\User;
use Lucid\Units\Operation;

class ChangePasswordOperation extends Operation
{
    private string $password;
    private User $user;

    /**
     * Create a new operation instance.
     *
     * @param string $password
     * @param User $user
     */
    public function __construct(string $password, User $user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $hashedNewPassword = $this->run(MakeHashPasswordJob::class, [
            'password' => $this->password
        ]);

        $this->run(RevokeAllAuthenticationTokensJob::class, [
            'user' => $this->user
        ]);

        $this->run(SetNewPasswordJob::class, [
            'user' => $this->user,
            'password' => $hashedNewPassword
        ]);
    }
}
