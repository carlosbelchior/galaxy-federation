<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Planet;
use App\Models\Resource;
use App\Models\Router;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddController extends Controller
{

    // Add new pilot
    public function pilots(Request $request)
    {
        // Validate input data
        $input = $request->all();
        $validator = Validator::make( $input, [
            'pilot_certification' => 'required|numeric|digits_between:7,7',
            'name' => 'required|min:3|max:255',
            'age' => 'required|numeric|digits_between:2,10',
            'credits' => 'required|numeric',
            'location_planet' => 'required|min:4'
        ]);
        if($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        // Check planet exist
        if(!Planet::getPlanet($request->input('location_planet')))
            return 'Planet not found.';

        // Check age is valid
        if($request->input('age') < 18)
            return 'Pilot does not have a minimum age requirement.';

        // Check certification
        if(Pilot::where('pilot_certification', $request->input('pilot_certification'))->get()->count() > 0)
            return 'There is already a registered pilot with this certification';

        // Save pilot
        $pilot = Pilot::create($request->all());
        if($pilot)
            return 'Pilot registered successfully!!';

        // Error message
        return 'The Galaxy Federation alert!! An error occurred, check your connection and try again!!';
    }

    // Add new ship
    public function ships(Request $request)
    {
        // Validate input data
        $input = $request->all();
        $validator = Validator::make( $input, [
            'fuel_capacity' => 'required|numeric|digits_between:1,10',
            'fuel_level' => 'required|numeric|digits_between:1,10',
            'weight_capacity' => 'required|numeric|digits_between:1,10',
            'location_planet' => 'required|min:4'
        ]);
        if($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        // Check planet exist
        if(!Planet::getPlanet($request->input('location_planet')))
            return 'Planet not found.';

        // Check fuel capacity and level
        if($request->fuel_capacity < $request->fuel_level)
            // Error message
            return 'Capacity exceeded, please check fuel level.';

        // Check weight capacity
        if($request->weight_capacity < 1)
            // Error message
            return 'The weight cannot be less than 1.';

        // Save ship
        $ship = Ship::create($request->all());
        if($ship)
            return 'Ship registered successfully.';

        // Default error message
        return 'The Galaxy Federation alert!! An error occurred, check your connection and try again!!';
    }

    // Add new contract
    public function contracts(Request $request)
    {
        // Validate input data
        $input = $request->all();
        $validator = Validator::make( $input, [
            'description' => 'required|min:5',
            'pilot' => 'required|numeric|digits_between:7,7',
            'ship' => 'required|numeric|digits_between:1,10',
            'payload' => 'required',
            'origin_planet' => 'required|min:4',
            'destination_planet' => 'required|min:4',
            'value' => 'required|numeric|digits_between:1,10',
        ]);
        if($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        // Check planet exist
        if(!Planet::getPlanet($request->input('origin_planet')) || !Planet::getPlanet($request->input('destination_planet')))
            return 'Planet not found, please fill in correctly.';

        // Check travel
        $fuelShip = Router::getRouter($request->origin_planet, $request->destination_planet);
        if(!$fuelShip)
            return 'This route is not authorized.';

        // Check pilot
        $pilot = Pilot::where('pilot_certification', $request->pilot)->first();
        if(!$pilot)
            return 'Pilot not found.';

        // Check ship
        $ship = Ship::find($request->ship);
        if(!$ship)
            return 'Ship not found.';

        // Check payload
        if(count($request->payload) < 1)
            return 'Payload cannot be empty.';

        // Check payload and max payload ship
        $total_payload = 0;
        foreach($request->payload as $key => $value)
        {
            if($key != "minerals" && $key != "water" && $key != "food")
                return $key;
            else
                $total_payload += $value;
        }
        if($ship->weight_capacity < $total_payload)
            return 'The ship does not support this cargo. Reduce the weight.';

        // Save contract
        $contract = Contract::create([
            'description' => $request->description,
            'pilot_id' => $pilot['id'],
            'ship_id' => $ship['id'],
            'payload' => $total_payload,
            'origin_planet' => $request->origin_planet,
            'destination_planet' => $request->destination_planet,
            'value' => $request->value,
        ]);
        if($contract)
        {
            // Save resource contract
            foreach($request->payload as $key => $value)
                Resource::create(['contract_id' => $contract->id, 'name' => $key, 'weight' => $value]);

            return 'Contract registered successfully.';
        }

        // Default error message
        return 'The Galaxy Federation alert!! An error occurred, check your connection and try again!!';
    }
}
