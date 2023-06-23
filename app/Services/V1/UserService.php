<?php

namespace App\Services\V1;

use App\Repositories\V1\UserRepository;

class UserService implements UserRepository
{
    public function createUser()
    {
        return "Welcome Repository";
    }
}
