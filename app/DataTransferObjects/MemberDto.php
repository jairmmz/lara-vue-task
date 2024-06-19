<?php

namespace App\DataTransferObjects;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;

class MemberDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) { }

    // private static function fromRequest($request): MemberDto
    // {
    //     return new MemberDto(
    //         name: $request->validated('name'),
    //         email: $request->validated('email')
    //     );
    // }

    public static function requestStore(MemberStoreRequest $request): MemberDto
    {
        return new MemberDto(
            name: $request->validated('name'),
            email: $request->validated('email')
        );
        // return self::fromRequest($request);
    }

    public static function requestUpdate(MemberUpdateRequest $request): MemberDto
    {
        return new MemberDto(
            name: $request->validated('name'),
            email: $request->validated('email')
        );
        // return self::fromRequest($request);
    }

}
