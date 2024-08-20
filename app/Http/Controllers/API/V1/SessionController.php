<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sessions\SessionStoreRequest;
use App\Http\Resources\V1\SessionCollection;
use App\Http\Resources\V1\SessionResource;
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
        },'game'=>fn($query)=>$query->withTrashed() ])->orderBy('created_at','desc')->paginate($page_size);
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



// get the session for last 30 days or this month this year
public function getSessionsByDate(Request $request){
    $date = $request->date ?? date('Y-m-d');
    $sessions = Session::whereDateBetween('created_at',Carbon::now()->subDays(2))->get();
    return $this->returnData($sessions,'Sessions retrieved successfully',200);
}


}


