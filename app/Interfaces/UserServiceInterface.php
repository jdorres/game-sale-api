<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getAllUsers(): Collection;
    public function getUserById($id): User;
    public function createUser(array $data): User;
    public function updateUser(int $id, array $data): ?User;
    public function deleteUser($id): bool;
}
