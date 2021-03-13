<?php

namespace App\Services\Authentication\Http\Controllers;

use App\Services\Authentication\Features\LoginUserFeature;
use App\Services\Authentication\Features\LogoutUserFeature;
use App\Services\Authentication\Features\RecoveryUserFeature;
use App\Services\Authentication\Features\RegisterUserFeature;
use App\Services\Authentication\Features\ResetCurrentPasswordFeature;
use Lucid\Units\Controller;

class AuthenticationController extends Controller
{
    public function register()
    {
        return $this->serve(RegisterUserFeature::class);
    }

    public function login()
    {
        return $this->serve(LoginUserFeature::class);
    }

    public function logout()
    {
        return $this->serve(LogoutUserFeature::class);
    }

    public function recovery()
    {
        return $this->serve(RecoveryUserFeature::class);
    }

    public function reset()
    {
        return $this->serve(ResetCurrentPasswordFeature::class);
    }
}
