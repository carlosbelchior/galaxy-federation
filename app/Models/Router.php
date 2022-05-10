<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory;
    protected $fillable = ['origin_planet', 'destiny_planet', 'coust'];

    public static function getRouter($origin_planet, $destiny_planet){
        return Router::where('origin_planet', $origin_planet)->where('destiny_planet', $destiny_planet)->first();
    }
}
