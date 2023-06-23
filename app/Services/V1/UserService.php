<?php

namespace App\Services\V1;

use App\Models\User;
use App\Repositories\V1\UserRepository;

class UserService implements UserRepository
{
    public function createUser(array $request)
    {
        return User::create($request);
    }

    public function users()
    {
        return User::get();
    }

    public function user($userUuid)
    {
        return User::where(['uuid' => $userUuid])->first();
    }

}
