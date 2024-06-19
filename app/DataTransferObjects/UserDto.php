<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class UserDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) { }

    public static function requestRegister(UserRegisterRequest $request): UserDto
    {
        return new UserDto(
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }

    public static function requestLogin(UserLoginRequest $request): UserDto
    {
        return new UserDto(
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
