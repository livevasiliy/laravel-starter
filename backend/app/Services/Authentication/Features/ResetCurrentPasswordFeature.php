<?php

namespace App\Services\Authentication\Features;

use App\Domains\Authentication\Jobs\CreateAuthenticationTokenJob;
use App\Domains\Authentication\Requests\ResetCurrentPassword;
use App\Domains\User\Jobs\CompareUserPasswordJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Services\Authentication\Http\Resource\AuthenticationUserResource;
use App\Services\Authentication\Operations\ChangePasswordOperation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class ResetCurrentPasswordFeature extends Feature
{
    public function handle(ResetCurrentPassword $request)
    {
        try
        {
            $fetchUser = $this->run(GetUserByEmailJob::class, [
                'email' => $request->input('email')
            ]);

            $oldPasswordIsMatch = $this->run(CompareUserPasswordJob::class, [
                'password' => $request->input('current_password'),
                'user' => $fetchUser
            ]);

            if ($oldPasswordIsMatch) {
                $this->run(ChangePasswordOperation::class, [
                    'user' => $fetchUser,
                    'password' => $request->input('new_password')
                ]);

                $token = $this->run(CreateAuthenticationTokenJob::class, [
                    'user' => $fetchUser
                ]);

                return $this->run(RespondWithJsonJob::class, [
                    'content' => AuthenticationUserResource::make($token)
                ]);
            }
            return $this->run(RespondWithJsonErrorJob::class, [
                'content' => trans('auth.password'),
                'status' => Response::HTTP_BAD_REQUEST
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
