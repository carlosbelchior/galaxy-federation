<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'pilot_id', 'ship_id', 'payload', 'origin_planet', 'destination_planet', 'value', 'status_complete', 'accepted'];

    public function pilot()
    {
        return $this->hasOne(Pilot::class, 'id', 'pilot_id')->select('id', 'name');
    }

    public function ship()
    {
        return $this->hasOne(Ship::class, 'id', 'ship_id');
    }
}
