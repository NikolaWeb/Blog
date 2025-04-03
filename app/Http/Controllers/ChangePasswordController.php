<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use App\Services\UserServices;

class ChangePasswordController extends Controller
{
    private UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
       
    }

    #[OA\Patch(
        path: '/change-password',
        summary: 'Izmena password-a za korisnika',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['old_password', 'new_password'],
                    properties: [
                        new OA\Property(property: 'old_password', type: 'string', default: 'Trenutna lozinka'),
                        new OA\Property(property: 'new_password', type: 'string', default: 'Nova lozinka', minLength: 8),                     
                     
                    ]
                )
            )
        ),
        tags: ['Users'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Izmena password-a korisnika'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = auth()->user();
        if (!$user || !\Hash::check($data['old_password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $result = $this->userServices->changePassword($data, $user);

        return response()->json([
            'message' => 'Uspesno promenjena lozinka',
            'data' => $result
        ]);
    }
}
