<?php

namespace App\Services;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Collection;

class AuthServices {

    public function findUserByName(string $name): ?User
    {
        return User::where('name', $name)
        ->where('active', 1)
        ->first();
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => $user
            // 'user_id' => $user->id,
            // 'user_name' => $user->name,
            // 'user_role' => $user->role
        ]);
    }

}