<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\Member;
use App\Services\MemberService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(
        private MemberService $memberService
    ) { }

    public function index(Request $request): JsonResponse
    {
        try {
            $query = $request->get('query');
            $members = $this->memberService->index($query);
            
            return $this->success('Miembros obtenidos exitosamente', $members);
        } catch (Exception $e) {
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function store(MemberStoreRequest $request): JsonResponse
    {
        try {
            $member = $this->memberService->store($request->validated());

            return $this->success('Miembro creado exitosamente', $member, 201);
        } catch (Exception $e) {
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function update(Member $member, MemberUpdateRequest $request): JsonResponse
    {
        try {
            $memberUpdate = $this->memberService->update($member, $request->validated());

            return $this->success('Miembro actualizado exitosamente', $memberUpdate);
        } catch (\Throwable $th) {
            return $this->badRequest('Ocurrio un error inesperado', $th->getMessage());
        }
    }
}
