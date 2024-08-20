<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Traits\ApiRessourceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller


{
    use ApiRessourceTrait;



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
public function getSessionsByDate(Request $request){
    $date = $request->date ?? date('Y-m-d');
    $sessions = Session::whereDateBetween('created_at',Carbon::now()->subDays(2))->get();
    return $this->returnData($sessions,'Sessions retrieved successfully',200);
}
public function getTotalAmountByDeviceAndGameAndUser(Request $request){
    $device_id = $request->device_id;
    $game_id = $request->game_id;
    $user_id = $request->user_id;
    $totalAmount = Session::where('device_id',$device_id)->where('game_id',$game_id)->where('user_id',$user_id)->sum('amount');
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
public function getTotalAmountByDevice(Request $request){
    $totalAmount = Session::select('devices.name',DB::raw('sum(amount) as total'))
    ->join('devices', 'sessions.device_id', '=', 'devices.id')
    ->whereNull('devices.deleted_at')
    ->groupBy('devices.id')
    ->get();
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
public function getTotalAmountByGame(Request $request){
    $totalAmount = Session::select('games.name',DB::raw('sum(amount) as total'))
    ->join('games', 'sessions.game_id', '=', 'games.id')
    ->whereNull('games.deleted_at')
    ->groupBy('games.id')
    ->get();
    return $this->returnData($totalAmount,'Total amount retrieved successfully',200);
}
}
