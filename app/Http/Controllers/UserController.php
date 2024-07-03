<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(UserResource::collection($users), Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try{
            $data = $request->validated();
            $user = User::create($data);
            return response()->json(new UserResource($user), Response::HTTP_CREATED);
        }catch(Exception $e){
            //TODO
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){
        $user = User::findOrFail($id);
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try{
            $data = $request->all();
            $user = User::findOrFail($id);
            $user->update($data);
            return response()->json($user, Response::HTTP_OK);
        }catch(Exception $e){
            //TODO
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return response()->json([], Response::HTTP_OK);
    }
}
