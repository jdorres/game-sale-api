<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json(UserResource::collection($users), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->userService->createUser($data);
            return response()->json(new UserResource($user), Response::HTTP_CREATED);
        } catch (Exception $e) {
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->userService->updateUser($id, $data);
            return response()->json($user, Response::HTTP_OK);
        } catch (Exception $e) {
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json([], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => 'Falha ao deletar usuário'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
