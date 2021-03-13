<?php

declare(strict_types=1);

namespace App\Data\DataTransferObjects;

use App\Domains\Authentication\Requests\RegisterUserRequest;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateUserRequestData extends DataTransferObject
{
    public string $email;

    public string $name;

    public string $password;

    public static function fromRequest(RegisterUserRequest $request): self
    {
        return new static([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => $request->input('password')
        ]);
    }
}
