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

    // Add new pilot
    public function pilots(Request $request)
    {
        // Check planet exists
        if(!array_search($request->input('location_planet'), $this->planets))
            return ['The Galaxy Federation alert!! Planet not found!!'];

        // Check age is valid
        if($request->input('age') < 18)
            return ['The Galaxy Federation alert!! Pilot does not have a minimum age requirement!!'];

        // Validate data input for new pilot
        $validated = $request->validate([
            'pilot_certification' => 'required|numeric',
            'name' => 'required|min:3',
            'age' => 'required|numeric',
            'credits' => 'required|numeric',
            'location_planet' => 'required|min:4'
        ]);

        if($validated)
        {
            // Save pilot
            Pilot::create($request->all());
            return ['Pilot registered successfully!!'];
        }
        
        // Error message
        return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];
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

        if($validated)
        {
            Ship::create($request->all());
            return ['Ship registered successfully!!'];
        }

        // Error message
        return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];
    }

    // Add new contract
    public function contracts(Request $request)
    {
        // Check planet exists
        if(!array_search($request->input('origin_planet'), $this->planets) || !array_search($request->input('destination_planet'), $this->planets))
            return ['The Galaxy Federation alert!! Planet not found, please fill in correctly!'];

        // Validate data input for new contract
        $validated = $request->validate([
            'description' => 'required|min:5',
            'payload' => 'required|numeric|digits_between:1',
            'origin_planet' => 'required|min:4',
            'destination_planet' => 'required|min:4',
            'value' => 'required|numeric|digits_between:1',
        ]);

        if($validated)
        {
            // Save contract
            Contract::create($request->all());
            return ['Contract registered successfully!!'];
        }

        // Error message
        return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];
    }
}