<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Purchase;
use Exception;

class GameService
{
    public function linkGamesToPurchase(Purchase $purchase, array $gameCodes)
    {
        foreach($gameCodes as $gameCode){
            $game = Game::where('code', $gameCode)->first();
            if(!$game){
                //TODO: deveria rolar um rollback da compra aqui?
                throw new Exception("Game not found!");
            }
            $purchase->games()->attach($game->id);
        }
        $purchase->save();

        return $purchase;
    }
}