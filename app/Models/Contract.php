<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'payload', 'origin_planet', 'destination_planet', 'value', 'status_complete', 'accepted'];
}