<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
  protected User $model;

  public function __construct(User $user)
  {
    $this->model = $user;
  }

  public function index(): Collection
  {
    return $this->model->all();
  }

  public function find($id): ?User
  {
    return $this->model->find($id);
  }

  public function store(array $data): User
  {
    $user = $this->model->create($data);
    return $user;
  }

  public function update(User $user, array $data): User
  {
    $user->update($data);
    return $user->fresh();
  }

  public function delete(User $user): bool
  {
    return $user->delete();
  }
}
