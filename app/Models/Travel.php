<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $table = 'travels';
    protected $fillable = ['pilot_id', 'ship_id', 'origin_planet', 'destiny_planet'];
}
