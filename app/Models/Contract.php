<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'pilot_id', 'ship_id', 'payload', 'origin_planet', 'destination_planet', 'value', 'status_complete', 'accepted'];
}