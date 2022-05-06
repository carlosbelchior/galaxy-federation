<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Resource;
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
        'Calas-Aqua' => 15,
        'Andvari-Demeter' => 48,
        'Demeter-Andvari' => 45,
        'Aqua-Andvari' => 32,
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
            'pilot' => 'required|numeric|digits_between:7,7',
            'ship' => 'required|numeric|digits_between:1,10',
            'payload' => 'required',
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
        $ship = Ship::find($request->ship);
        if($ship->isEmpty())
            return ['Ship not found.'];

        // Check payload
        $payload = json_decode($request);
        if(empty($payload->{'payload'})
            return ['Payload cannot be empty.'];

        // Check payload and max payload ship
        $total_payload = 0;
        foreach($payload->{'payload'} as $pay)
            $total_payload += $pay;
        if($ship->weight_capacity < $total_payload)
            return ['The ship does not support this cargo. Reduce the weight.'];

        // Save contract
        $data = [
            'description' => $request->description,
            'pilot_id' => $pilot->id,
            'ship_id' => $ship->id,
            'payload' => $total_payload,
            'origin_planet' => $request->origin_planet,
            'destination_planet' => $request->destination_planet,
            'value' => $request->value,
        ];
        $contract = Contract::create($data);
        if($contract)
        {
            // Save resource contract
            foreach($payload->{'payload'} as $pay)
                Resource::create(['contract_id' => $contract->id, 'name' => $pay['name'], 'weight' => $pay['weight']]);

            return ['Contract registered successfully.'];
        }

        // Default error message
        return ['The Galaxy Federation alert!! An error occurred, check your connection and try again!!'];
    }
}