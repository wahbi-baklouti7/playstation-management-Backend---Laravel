<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'start_time', 'end_time', 'user_id', 'device_id', 'game_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function device()
    {
        return $this->belongsTo(Device::class);
    }


    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
