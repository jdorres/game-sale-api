<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class UserService implements UserServiceInterface
{
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getAllUsers(): Collection
  {
    $list = $this->userRepository->index();
    return $list;
  }

  public function getUserById($id): User
  {
    $user = $this->userRepository->find($id);
    if ($user) {
      return $user;
    }
    throw new Exception('User not found', Response::HTTP_NOT_FOUND);
  }

  public function createUser(array $data): User
  {
    $user = $this->userRepository->store($data);
    return $user;
  }

  public function updateUser(int $id, array $data): ?User
  {
    $user = $this->userRepository->find($id);
    if ($user) {
      return $this->userRepository->update($user, $data);
    }
    throw new Exception('User not found', Response::HTTP_NOT_FOUND);
  }

  public function deleteUser($id): bool
  {
    $user = $this->userRepository->find($id);
    if ($user) {
      return $this->userRepository->delete($user);
    }
    throw new Exception('User not found', Response::HTTP_NOT_FOUND);
  }
}
