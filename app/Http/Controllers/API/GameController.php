<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\GameStoreRequest;
use App\Http\Requests\Games\GameUpdateRequest;
use App\Models\Game;
use App\Models\User;
use App\Traits\ApiRessourceTrait;
use Illuminate\Http\Request;

class GameController extends Controller


{
    use ApiRessourceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->returnData(Game::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameStoreRequest $request)
    {


        $validates= $request->validated();
        $game = Game::create($validates);
        return $this->returnData($game,'Game created successfully',201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameUpdateRequest $request, Game $game)
    {


        try {
            $validates= $request->validated();
            $game->update($validates);
            return $this->returnData($game,'Game updated successfully',201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator);
            return $this->returnValidationError($e->validator);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return $this->successMessage('Game deleted successfully');
    }
}
