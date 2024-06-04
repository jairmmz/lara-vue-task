<?php

namespace App\Repositories;

use App\Events\NewUserEvent;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    public function register(array $data)
    {
        return User::create($data);
    }

    public function login(array $data)
    {
        return User::where('email', $data['email'])->first();
    }

    public function checkEmail($token)
    {
        return User::where('remember_token', $token)->first();
    }
}
