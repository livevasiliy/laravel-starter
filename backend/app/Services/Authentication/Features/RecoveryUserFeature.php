<?php

namespace App\Services\Authentication\Features;

use App\Domains\Authentication\Jobs\GenerateNewPasswordJob;
use App\Domains\Authentication\Jobs\SendEmailWithNewPasswordJob;
use App\Domains\Authentication\Requests\RecoveryUser;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Services\Authentication\Operations\ChangePasswordOperation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class RecoveryUserFeature extends Feature
{
    public function handle(RecoveryUser $request)
    {
        try
        {
            $fetchUser = $this->run(GetUserByEmailJob::class, [
                'email' => $request->input('email')
            ]);
            $password = $this->run(GenerateNewPasswordJob::class);
            $this->run(ChangePasswordOperation::class, [
                'user' => $fetchUser,
                'password' => $password
            ]);
            $this->run(SendEmailWithNewPasswordJob::class, [
                'email' => $fetchUser->email,
                'password' => $password
            ]);
            return $this->run(RespondWithJsonJob::class, [
                'content' => trans('passwords.sent')
            ]);
        }
        catch (ModelNotFoundException $modelNotFoundException)
        {
            return $this->run(RespondWithJsonErrorJob::class, [
                'content' => trans('passwords.user'),
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }
}
