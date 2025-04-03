<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    private AuthServices $authServices;

    public function __construct(AuthServices $authServices) {
        $this->authServices = $authServices;
    }

    #[OA\Post(
        path: '/auth/login',
        summary: 'Prijava korisnika za web aplikaciju',
        requestBody: new OA\RequestBody(required: true,
        content: new OA\MediaType(mediaType: 'application/json',
        schema: new OA\Schema(required: ['name', 'password'],
            properties: [
                new OA\Property(property: 'name', type: 'string', default: 'korisnik', description: 'ime korisnika'),
                new OA\Property(property: 'password', type: 'string', default: 'korisnik', description: 'lozinka'),
            ]
        ),
    )),
        tags: ['Auth'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Korisnik prijavljen'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);  
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $credentials = $request->only('name', 'password');

        $user = $this->authServices->findUserByName($credentials['name']);

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (! $token = auth()->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->authServices->respondWithToken($token, $user);
    }
    
    #[OA\Post(
        path: "/auth/logout",
        summary: "Odjava korisnika",
        tags: ["Auth"],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Korisnik odjavljen"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function logout()
    {
        auth()->logout();
        // if (!request()->is('api/*')) {
        //     session()->remove('user');
        // }
        return response()->json(['message' => 'Successfully logged out']);
    }

    #[OA\Get(
        path: "/auth/whoami",
        summary: "Podaci o korisniku na osnovu tokena",
        tags: ["Auth"],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Podaci o korisniku vraćeni na front"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function whoami()
    {
        $user = auth()->user();
        // $user->load(['role', 'ispostave']); // Učitaj povezane modele
        return response()->json($user);
    }
}
