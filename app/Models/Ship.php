<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $fillable = ['fuel_capacity', 'fuel_level', 'location_planet', 'weight_capacity'];
}
