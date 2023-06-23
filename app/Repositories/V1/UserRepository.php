<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface UserRepository
{
    public function createUser(array $request);

    public function users();

    public function user($userUuid);
}
