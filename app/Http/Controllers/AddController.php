<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Ship;
use Illuminate\Http\Request;

class AddController extends Controller
{
    // Planets
    private $planets = array(1 => 'Andvari', 2 => 'Demeter', 3 => 'Aqua', 4 => 'Calas');
    // Ships available
    private $shipsAvailable = array(
        'Andvari-Aqua' => 13, 
        'Andvari-Calas' => 23, 
        'Demeter-Aqua' => 22, 
        'Demeter-Calas' => 25, 
        'Aqua-Demeter' => 30, 
        'Aqua-Calas' => 12, 
        'Calas-Andvari' => 20, 
        'Calas-Demeter' => 25, 
        'Calas-Aqua' => 15
    );

    // Add new pilot
    public function pilots(Request $request)
    {
        // Validate data input for new pilot
        $validator = $request->validate([
            'pilot_certification' => 'required|numeric|digits_between:7,7',
            'name' => 'required|min:3|max:255',
            'age' => 'required|numeric|digits_between:2,10',
            'credits' => 'required|numeric',
            'location_planet' => 'required|min:4'
        ]);

        if($validator->fails())
            // Error message
            return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];
        
        // Check planet exist
        if(!array_search($request->input('location_planet'), $this->planets))
            return ['The Galaxy Federation alert!! Planet not found!!'];

        // Check age is valid
        if($request->input('age') < 18)
            return ['The Galaxy Federation alert!! Pilot does not have a minimum age requirement!!'];

        // Save pilot
        $pilot = Pilot::create($request->all());
        if($pilot)
            return ['Pilot registered successfully!!'];

        // Error message
        return ['The Galaxy Federation alert!! An error occurred, check your connection and try again!!'];
    }

    // Add new ship
    public function ships(Request $request)
    {
        // Validate data input for new pilot
        $validated = $request->validate([
            'fuel_capacity' => 'required|numeric|digits_between:1,10',
            'fuel_level' => 'required|numeric|digits_between:1,10',
            'weight_capacity' => 'required|numeric|digits_between:1,10'
        ]);

        if($validator->fails())
            // Error message
            return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];

        // Check fuel capacity and level
        if($request->fuel_capacity < $request->fuel_level)
            // Error message
            return ['Capacity exceeded, please check fuel level.'];

        // Check weight capacity
        if($request->weight_capacity < 1)
            // Error message
            return ['The weight cannot be less than 1.'];

        // Save ship
        $ship = Ship::create($request->all());
        if($ship)
            return ['Ship registered successfully!!'];
        
        // Default error message
        return ['The Galaxy Federation alert!! An error occurred, check your connection and try again!!'];
    }

    // Add new contract
    public function contracts(Request $request)
    {
        // Validate data input for new contract
        $validated = $request->validate([
            'description' => 'required|min:5',
            'payload' => 'required|numeric|digits_between:1',
            'pilot' => 'required|numeric|digits_between:7,7',
            'origin_planet' => 'required|min:4',
            'destination_planet' => 'required|min:4',
            'value' => 'required|numeric|digits_between:1',
        ]);

        if($validator->fails())
            // Error message
            return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];

        // Check planet exist
        if(!array_search($request->input('origin_planet'), $this->planets) || !array_search($request->input('destination_planet'), $this->planets))
            return ['Planet not found, please fill in correctly.'];

        // Check travel
        $fuelShip = $this->shipsAvailable[$request->origin_planet . '-' . $request->destination_planet];
        if(!$fuelShip)
            return ['This route is not authorized.'];

        // Check pilot
        $pilot = Pilot::where('pilot_certification', $request->pilot)->first();
        if($pilot->isEmpty())
            return ['Pilot not found.'];

        // Check ship
        $ship = Ship::find($request->payload);
        if($ship->isEmpty())
            return ['Ship not found.'];

        // Save contract
        $contract = Contract::create($request->all());
        if($contract)
            return ['Contract registered successfully.'];

        // Default error message
        return ['The Galaxy Federation alert!! An error occurred, check your connection and try again!!'];
    }
}