<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use App\Models\Report;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuelController extends Controller
{
    public function buy(Request $request)
    {
        // Validate input data
        $input = $request->all();
        $validator = Validator::make( $input, [
            'pilot_certification' => 'required|numeric|digits_between:7,7',
            'ship' => 'required|numeric|digits_between:1,10',
            'refill' => 'required|numeric|digits_between:1,10',
        ]);
        if($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        // Check pilot
        $pilot = Pilot::where('pilot_certification', $request->pilot_certification)->first();
        if(!$pilot)
            return ['Pilot not found.'];

        // Check ship
        $ship = Ship::find($request->ship);
        if(!$ship)
            return ['Ship not found.'];

        // Check available fuel ship capacity
        if(($ship->fuel_level + $request->refill) > $ship->fuel_capacity)
            return [
                'Refill exceeds the ship maximum available. Available:' . 
                ($ship['fuel_capacity'] - $ship->fuel_level) . ' | ' .
                'Max: ' . $ship['fuel_capacity']
            ];

        // Check available credit pilot
        if($pilot->credits < ($request->refill * 7))
            return ['Pilot does not have enough credit'];

        // If everything went right, it generates the purchase of fuel
        $ship->fuel_level += $request->refill;
        $ship->save();
        $pilot->credits -= ($request->refill * 7);
        $pilot->save();

        // Register buy fuel in log
        Report::create(['description' => $pilot->name . ' bought fuel: +₭' . ($request->refill * 7)]);

        return ['Refueling done successfully, amount deducted from the pilot wallet.'];
    }
}
