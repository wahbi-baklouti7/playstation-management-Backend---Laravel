<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sessions\SessionStoreRequest;
use App\Models\Device;
use App\Models\Game;
use App\Models\Session;
use App\Models\User;
use App\Traits\ApiRessourceTrait;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    use ApiRessourceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return $this->returnData(Session::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SessionStoreRequest $request)
    {

        $validates = $request->validated();
        $session = Session::create($validates);
        return $this->returnData($session,'Session created successfully',201);

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        //

        $session->delete();
        return $this->successMessage('Session deleted successfully');
    }

    // get all sessions for a specific user
    public function getUserSessions(User $user){


        return $this->returnData($user->sessions()->get(),'Sessions retrieved successfully',200);
    }

    // get all sessions for a specific device
    public function getDeviceSessions(Device $device){

        return $this->returnData($device->sessions()->get(),'Sessions retrieved successfully',200);
    }

    // get all sessions for a specific game
    public function getGameSessions(Game $game){

        return $this->returnData($game->sessions()->get(),'Sessions retrieved successfully',200);
    }
}
