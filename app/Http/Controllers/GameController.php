<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Http\Requests\GameUpdateRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return response()->json(GameResource::collection($games), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameStoreRequest $request)
    {
        try{
            $data = $request->validated();
            $data['code'] = Str::random(25);
            $game = Game::create($data);
            return response()->json(new GameResource($game), Response::HTTP_CREATED);
        }catch(Exception $e){
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){
        $game = Game::findOrFail($id);
        return response()->json(new GameResource($game), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameUpdateRequest $request, string $id)
    {
        try{
            $data = $request->all();
            $game = Game::findOrFail($id);
            $game->update($data);
            return response()->json($game, Response::HTTP_OK);
        }catch(Exception $e){
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Game::destroy($id);
        return response()->json([], Response::HTTP_OK);
    }
}
