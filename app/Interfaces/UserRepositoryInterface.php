<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function index(): Collection;
    public function find($id): ?User;
    public function store(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}
