<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }

    private function userIsAdmin($user): bool {
        return $user->type === config('blog.config_user_types.admin');
    }
    private function userCreateTechnicianType($user, $data): bool {
        return $user->type === config('blog.config_user_types.korisnik') && $data === config('blog.config_user_types.monter');
    }

    public function store(User $user, array $data): Response
    {
        // Ako je user admin
        if($this->userIsAdmin($user)) {
            return  Response::allow();
        }
        // Ako je user korisnik i kreira montera
        if($this->userCreateTechnicianType($user, $data['type'])) {
            return  Response::allow();
        }
        return Response::deny('Korisnik nema pravo na ovu akciju.');
    }
    public function update(User $user, array $data): Response
    {
        // Ako je user admin
        if($this->userIsAdmin($user)) {
            return  Response::allow();
        }
        // Ako je user korisnik i kreira montera
        if($this->userCreateTechnicianType($user, $data['type'])) {
            return  Response::allow();
        }
        return Response::deny('Korisnik nema pravo na ovu akciju.');
    }
    public function delete(User $user, User $resource): Response
    {
        // Ako je user admin
        if($this->userIsAdmin($user)) {
            return  Response::allow();
        }
        // Ako je user korisnik i kreira montera
        if($this->userCreateTechnicianType($user, $resource->type)) {
            return  Response::allow();
        }
        return Response::deny('Korisnik nema pravo na ovu akciju.');
    }
}
