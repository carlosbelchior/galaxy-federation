<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Planet;
use App\Models\Resource;
use App\Models\Router;
use App\Models\Ship;
use App\Models\Travel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TravelsController extends Controller
{

    public function new(Request $request)
    {
        // Validate input data
        $input = $request->all();
        $validator = Validator::make( $input, [
            'pilot_certification' => 'required|numeric|digits_between:7,7',
            'ship' => 'required|numeric|digits_between:1,10',
            'origin_planet' => 'required|min:4|max:7',
            'destination_planet' => 'required|min:4|max:7'
        ]);
        if($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        // Check planet exist
        if(!Planet::getPlanet($request->input('origin_planet')) || !Planet::getPlanet($request->input('destination_planet')))
            return 'Planet not found, please fill in correctly.';

        // Get pilot
        $pilot = Pilot::where('pilot_certification', $request->pilot_certification)->first();
        if(!$pilot)
            return 'Pilot not found.';

        // Check location pilot
        if($pilot->location_planet != $request->origin_planet)
            return 'This pilot is not on the origin planet.';

        // Get ship
        $ship = Ship::find($request->ship);
        if(!$ship)
            return 'Ship not found.';

        // Check location ship
        if($ship->location_planet != $request->origin_planet)
            return 'This ship is not on the origin planet.';

        // Check ship fuel
        $fuelShip = Router::getRouter($request->origin_planet, $request->destination_planet)->coust;
        if($ship->fuel_level < $fuelShip)
            return 'The ship does not have enough fuel for this trip. Replenishment is needed.';

        // Start transaction
        DB::beginTransaction();

        try {

            // Save travel log
            Travel::create([
                'pilot_id' => $pilot->id,
                'ship_id' => $request->ship,
                'origin_planet' => $request->origin_planet,
                'destiny_planet' => $request->destination_planet
            ]);

            // Update location pilot
            $pilot->location_planet = $request->destination_planet;
            $pilot->save();

            // Update location ship and update fuel
            $ship->fuel_level -= $fuelShip;
            $ship->location_planet = $request->destination_planet;
            $ship->save();

            DB::commit();

            return 'Successful trip.';

        } catch(Exception $e) {
            DB::rollback();
            return 'Error trip. Check data and try again.';
        }
    }
}
