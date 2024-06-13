<?php

namespace App\Services;

use App\Models\Member;

class MemberService
{
    public function index(?string $query): mixed
    {
        $members = Member::select('id', 'name', 'email');

        if (!is_null($query) && !empty($query)) {
            // Buscar por nombre o correo electrónico
            $members->where('name', 'like', "%$query%")->orWhere('email', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return $members->paginate(5);
    }

    public function store(array $data): Member
    {
        $member = Member::create($data);

        return $member;
    }

    public function update(Member $member, array $data): Member
    {
        $member->update($data);

        return $member;
    }
}
