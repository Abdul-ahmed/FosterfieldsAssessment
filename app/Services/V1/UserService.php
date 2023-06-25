<?php

namespace App\Services\V1;

use App\Models\User;
use App\Repositories\V1\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService implements UserRepository
{
    public function createUser($request)
    {
        return User::create($request);
    }

    public function users()
    {
        return User::paginate(10);
    }

    public function user($userUuid)
    {
        return User::where(['uuid' => $userUuid])->first();
    }

    public function login($request)
    {
        $user = User::where(['email'=> $request['email']])->first();
        if ($user) {
            $password = Hash::check($request['password'], $user->password);
            if ($password) {
                return $user;
            }
            return $password;
        }
        return $user;
    }

}
