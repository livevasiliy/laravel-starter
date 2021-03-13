<?php

namespace App\Services\Authentication\Features;

use App\Data\DataTransferObjects\CreateUserRequestData;
use App\Domains\Authentication\Jobs\CreateAuthenticationTokenJob;
use App\Domains\Authentication\Jobs\CreateUserJob;
use App\Domains\Authentication\Requests\RegisterUserRequest;
use App\Services\Authentication\Http\Resource\AuthenticationUserResource;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class RegisterUserFeature extends Feature
{
    public function handle(RegisterUserRequest $request)
    {
        $requestData = CreateUserRequestData::fromRequest($request);
        $user = $this->run(CreateUserJob::class, [
            'email' => $requestData->email,
            'name' => $requestData->name,
            'password' => $requestData->password
        ]);
        $token = $this->run(CreateAuthenticationTokenJob::class, [
            'user' => $user
        ]);
        return $this->run(RespondWithJsonJob::class, [
            'content' => AuthenticationUserResource::make($token)
        ]);
    }
}
