<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\MemberDto;
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
    ) {
    }

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
            $member = $this->memberService->store(MemberDto::requestStore($request));

            return $this->success('Miembro creado exitosamente', $member, 201);
        } catch (Exception $e) {
            // Refactorizar mensaje de error agregando un job o evento para el envio del mensaje de error al email del administrador...
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function update(MemberUpdateRequest $request, Member $member): JsonResponse
    {
        try {
            $memberUpdate = $this->memberService->update($member, MemberDto::requestUpdate($request));

            return $this->success('Miembro actualizado exitosamente', $memberUpdate);
        } catch (\Throwable $th) {
            return $this->badRequest('Ocurrio un error inesperado', $th->getMessage());
        }
    }
}
