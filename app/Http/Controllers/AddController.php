<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\Request;

class AddController extends Controller
{
    // Add new pilot
    public function pilots(Request $request)
    {
        // Validate data input for new pilot
        $validated = $request->validate([
            'pilot_certification' => 'required|numeric|digits_between:1000000,9999999',
            'name' => 'required|min:3',
            'age' => 'required|numeric|digits_between:18',
            'credits' => 'required|numeric|digits_between:0',
            'location_planet' => 'required|min:4',
        ]);

        if($validated)
        {
            Pilot::create($request->all());
            return ['Pilot registered successfully!!'];
        }

        return ['The Galaxy Federation alert!! One or more datas are invalids, please fill in correctly. Best regards!'];
    }

    // Add new ship
    public function ships(Request $request)
    {

    }

    // Add new contract
    public function contracts(Request $request)
    {

    }
}
