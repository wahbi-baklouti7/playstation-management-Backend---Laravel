<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sessions\SessionStoreRequest;
use App\Http\Resources\SessionCollection;
use App\Http\Resources\SessionResource;
use App\Models\Device;
use App\Models\Game;
use App\Models\Session;
use App\Models\User;
use App\Traits\ApiRessourceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    use ApiRessourceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $days = (int) $request->days;
        if($days>0){
            $date = Carbon::now()->subDays($days);
            $session = Session::select(DB::raw('DATE(created_at) as date'),DB::raw('SUM(amount) as amount'))->where('created_at','>',$date)->groupBy('date')->get();
            // $session = Session::where('created_at','>',$date)->groupBy('created_at')->get();
            // return $this->returnData(SessionResource::collection($session));
            return $this->returnData($session);
        }
    //     $session = Session::withTrashed()
    // ->with(['user', 'device', 'game'])
    // ->paginate($page_size);


        // dd("tst");
        // Benchmark::dd(fn()=>Session::count());
        // dd()
        $page_size = $request->page_size ?? 10;
    //     Benchmark::dd(fn()=>
    //     Session::with(['user','device'=>function($query){
    //         $query->withTrashed();
    //     },'game'=>fn($query)=>$query->withTrashed() ])->paginate($page_size)
    // );
        $session = Session::with(['user','device'=>function($query){
            $query->withTrashed();
        },'game'=>fn($query)=>$query->withTrashed() ])->paginate($page_size);
        // return $this->returnData(SessionResource::collection($session));
        return $this->returnData(new SessionCollection($session));
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

    // get the number of sessions for each game
    public function getGameSessionsCount(){


        try {
            $gameSessionsCount = Session::select('games.name', DB::raw('count(*) as total'))->
            join('games', 'sessions.game_id', '=', 'games.id')
            ->whereNull('games.deleted_at')
            ->groupBy('games.id')
            ->get();
            return $this->returnData($gameSessionsCount, 'Sessions retrieved successfully', 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error retrieving game sessions count: ' . $e->getMessage());

            return $this->errorMessage('Failed to retrieve game sessions count', 500);
        }


        // dd("fffff");
        // return "fffff";
        // return $this->returnData(11,'Sessions retrieved successfully',200);

        // $gameSessionsCount = Session::select('game_id',DB::raw('count(*) as total'))->groupBy('game_id')->get();
        // return $this->returnData($gameSessionsCount,'Sessions retrieved successfully',200);
}


// get the session for last 30 days or this month this year
public function getSessionsByDate(Request $request){
    $date = $request->date ?? date('Y-m-d');
    $sessions = Session::whereDateBetween('created_at',Carbon::now()->subDays(2))->get();
    return $this->returnData($sessions,'Sessions retrieved successfully',200);
}

// get the total amount of session  by each device and game and user
public function getTotalAmountByDeviceAndGameAndUser(Request $request){
    $device_id = $request->device_id;
    $game_id = $request->game_id;
    $user_id = $request->user_id;
    $totalAmount = Session::where('device_id',$device_id)->where('game_id',$game_id)->where('user_id',$user_id)->sum('amount');
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
// get the total amount of sessions grouped by  devices name
public function getTotalAmountByDevice(Request $request){
    $totalAmount = Session::select('devices.name',DB::raw('sum(amount) as total'))
    ->join('devices', 'sessions.device_id', '=', 'devices.id')
    ->groupBy('devices.id')
    ->get();
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
public function getTotalAmountByGame(Request $request){
    $totalAmount = Session::select('games.name',DB::raw('sum(amount) as total'))
    ->join('games', 'sessions.game_id', '=', 'games.id')
    ->groupBy('games.id')
    ->get();
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
}


