<?php

namespace App\Services;

use App\DataTransferObjects\MemberDto;
use App\Http\Resources\MemberResource;
use App\Models\Member;

class MemberService
{
    public function index(?string $query): mixed
    {
        $members = Member::select('id', 'name', 'email');

        if (!is_null($query) && !empty($query)) {
            $members->where('name', 'like', "%$query%")->orWhere('email', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return $members->paginate(5);
    }

    public function store(MemberDto $dto): MemberResource
    {
        $member = Member::create([
            'name' => $dto->name,
            'email' => $dto->email
        ]);

        return MemberResource::make($member);
    }

    public function update(Member $member, MemberDto $dto): MemberResource
    {
        $member->update([
            'name' => $dto->name,
            'email' => $dto->email
        ]);

        return MemberResource::make($member);
    }
}
