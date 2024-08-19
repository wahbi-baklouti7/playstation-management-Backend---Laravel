<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'price', 'extra_time_price'];


    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    // public function getNameAttribute(){
    //     return $this->attributes['name'];
    // }
}
