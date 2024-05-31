<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $members = Member::select('name', 'email');

        if ($query) {
            $members->where('name', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return response()->json([
            'members' => $members->paginate(10)
        ], 200);
    }

    public function store(MemberStoreRequest $request): JsonResponse
    {
        Member::create($request->validated());

        return response()->json([
            'message' => 'Miembro creado exitosamente'
        ], 201);
    }

    public function update(Member $member, MemberUpdateRequest $request): JsonResponse
    {
        $member->update($request->validated());

        return response()->json([
            'message' => 'Miembro actualizado exitosamente',
        ], 200);
    }
}
