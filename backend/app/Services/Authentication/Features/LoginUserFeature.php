<?php

namespace App\Services\Authentication\Features;

use App\Domains\Authentication\Jobs\CreateAuthenticationTokenJob;
use App\Domains\Authentication\Requests\LoginUserRequest;
use App\Domains\User\Jobs\CompareUserPasswordJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Services\Authentication\Http\Resource\AuthenticationUserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Lucid\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class LoginUserFeature extends Feature
{
    public function handle(LoginUserRequest $request)
    {
        try
        {
            $fetchUser = $this->run(GetUserByEmailJob::class, [
                'email' => $request->input('email')
            ]);

            $isMatch = $this->run(CompareUserPasswordJob::class, [
                'user' => $fetchUser,
                'password' => $request->input('password')
            ]);

            if ($isMatch) {
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
                'content' => $modelNotFoundException->getMessage(),
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }
}
