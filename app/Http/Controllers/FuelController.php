<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function buy(Request $request)
    {
        // Validate data input for buy fuel
        $validated = $request->validate([
            'ship' => 'required|numeric|digits_between:1,10',
            'pilot_certification' => 'required|numeric|digits_between:7,7',
            'refill' => 'required|numeric|digits_between:1,10',
        ]);

        // Check pilot
        $pilot = Pilot::where('pilot_certification', $request->pilot_certification)->first();
        if($pilot->isEmpty())
            return ['Pilot not found.'];

        // Check ship
        $ship = Ship::find($request->ship);
        if($ship->isEmpty())
            return ['Ship not found.'];

        // Check available fuel ship capacity
        if(($ship->fuel_level + $request->refill) > $ship->fuel_capacity)
            return [
                'Refill exceeds the ship maximum available. Available:' . 
                ($ship->fuel_capacity - $ship->fuel_level) . ' | ' .
                'Max: ' . $ship->fuel_capacity
            ];

        // Check available credit pilot
        if($pilot->credits < ($ship->refill * 7))
            return ['Pilot does not have enough credit'];

        // If everything went right, it generates the purchase of fuel
        $ship->fuel_level += $request->refill;
        $ship->save();
        $pilot->credits -= ($ship->refill * 7);
        $pilot->save();

        // Register buy fuel in log
        Report::create(['description' => $pilot->name . ' bought fuel: +₭' . ($ship->refill * 7)]);
    }
}
