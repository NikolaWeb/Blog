<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    private UserServices $userServices;
    private UserPolicy $userPolicy;

    public function __construct(UserServices $userServices, UserPolicy $userPolicy)
    {
        $this->userServices = $userServices;
        $this->userPolicy = $userPolicy;
    }

    #[OA\Get(
        path: "/users",
        summary: "Lista korisnika",
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                name: "type",
                in: "query",
                required: false,
                description: "Filter korisnika prema tipu korisnika",
                schema: new OA\Schema(type: "string", example: 'technician')
            ),
            new OA\Parameter(
                name: "active",
                in: "query",
                required: false,
                description: "Filter korisnika prema statusu aktivnosti",
                schema: new OA\Schema(type: "integer", example: 1)
            )          
        ],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Lista korisnika"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type');
        $active = $request->query('active');

        $result = $this->userServices->index($type, $active);

        return response()->json($result);
    }

    #[OA\Get(
        path: "/users/show/{id}",
        summary: "Korisnik",
        tags: ["Users"],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(parameter:'id', name: 'id', description: 'Users id', in: 'path', required:true)],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Korisnik"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function show($id): JsonResponse
    {
        $result = $this->userServices->show($id);

        return response()->json($result);
    }

    #[OA\Post(
        path: '/users/store',
        summary: 'Kreiranje novog korisnika',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['name', 'type', 'password'], // Dodao sam validna polja ovde
                    properties: [
                        new OA\Property(property: 'name', type: 'string', default: 'korisnicko ime'),
                        new OA\Property(property: 'password', type: 'string', default: '12345678', minLength: 8),                     
                        new OA\Property(property: 'firstname', type: 'string', default: 'ime korisnika'),
                        new OA\Property(property: 'lastname', type: 'string', default: 'prezime korisnika'),
                        new OA\Property(property: 'type', type: 'string', default: 'admin'), // ispravljen default value
                    ]
                )
            )
        ),
        tags: ['Users'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Kreiranje novog korisnika'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function store(UserStoreRequest $request): JsonResponse
    {     
        $data = $request->validated();

        // Polisa da li korisnik ima pravo na akciju
        $user = auth()->user();
        $authorizationResponse = $this->userPolicy->store($user, $data);
        if ($authorizationResponse->denied()) {
            return response()->json(['error' => $authorizationResponse->message()], 403);
        }

        $result = $this->userServices->store($data);

        return response()->json([
            'message' => 'Kornisk je kreiran',
            'data' => $result
        ]);
    }

    #[OA\Post(
        path: '/users/update/{id}',
        summary: 'Izmena postojećeg korisnika',
        parameters: [new OA\Parameter(parameter:'id', name: 'id', description: 'Users id', in: 'path', required:true)],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['name'], // Dodao sam validna polja ovde
                    properties: [
                        new OA\Property(property: 'name', type: 'string', default: 'korisnicko ime'),
                        new OA\Property(property: 'password', type: 'string', default: '12345678', minLength: 8),                     
                        new OA\Property(property: 'firstname', type: 'string', default: 'ime korisnika'),
                        new OA\Property(property: 'lastname', type: 'string', default: 'prezime korisnika'),
                        new OA\Property(property: 'type', type: 'string', default: 'admin'), // ispravljen default value
                        new OA\Property(property: 'active', type: 'integer', default: 1), // ispravljen default value
                    ]
                )
            )
        ),
        tags: ['Users'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Kreiranje novog korisnika'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        // Polisa da li korisnik ima pravo na akciju
        $user = auth()->user();
        $authorizationResponse = $this->userPolicy->update($user, $data);
        if ($authorizationResponse->denied()) {
            return response()->json(['error' => $authorizationResponse->message()], 403);
        }

        $result = $this->userServices->update($data, intval($id));

        return response()->json([
            'message' => 'Korisnik je izmenjen',
            'data' => $result
        ]);
    }

    #[OA\Delete(
        path: "/users/delete/{id}",
        summary: "Brisanje korisnika",
        tags: ["Users"],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(parameter:'id', name: 'id', description: 'Users id', in: 'path', required:true)],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Korisnik je obrisan"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function delete($id): JsonResponse
    {

        // Polisa da li korisnik ima pravo na akciju
        $user = auth()->user();
        $resource = User::find($id);

        $authorizationResponse = $this->userPolicy->delete($user, $resource);
        if ($authorizationResponse->denied()) {
            return response()->json(['error' => $authorizationResponse->message()], 403);
        }

        $result = $this->userServices->delete(intval($id));

        return response()->json(['message' => 'Korisnik je obrisan']);
    }


    
}
