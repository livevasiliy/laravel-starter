<?php

namespace App\Services\Authentication\Features;

use App\Domains\Authentication\Jobs\LogoutCurrentUserJob;
use App\Domains\Authentication\Requests\LogoutUserRequest;
use Lucid\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class LogoutUserFeature extends Feature
{
    public function handle(LogoutUserRequest $request)
    {
        $this->run(LogoutCurrentUserJob::class, [
            'user' => $request->user('sanctum')
        ]);
        return $this->run(RespondWithJsonJob::class, [
            'content' => trans('auth.token')
        ]);
    }
}
