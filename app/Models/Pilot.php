<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    use HasFactory;
    protected $fillable = ['pilot_certification', 'name', 'age', 'credits', 'location_planet'];
}
