<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Report;
use App\Models\Ship;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
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

    // List all open contracts
    public function all()
    {
        /* Get all open contracts
        *  Status: 0 is open, 1 is closed
        */
        $result = Contract::where('status_complete', 0)->orderBy('data_created')->get();

        // Check no data
        if($result->isEmpty())
            return ['No data available!'];

        // Show data
        return $result;
    }

    // Accept the contract
    public function accept($id)
    {
        // Get contract
        $contract = Contract::find($id);

        // Check status contract
        if($contract->status_complete == 1 || $contract->accepted == 1)
            return ['This contract is already accepted or finalized'];

        /* Update status accepted contract
        * 1 for accepted
        * Default: 0
        */
        $contract->accepted = 1;
        if($contract->save())
            return ['Contract successfully accepted'];

        // Default error message
        return ['The Galaxy Federation alert!! An error occurred, check your connection and try again!!'];
    }

    // Accept the contract
    public function final($id)
    {
        // Get contract
        $contract = Contract::find($id);

        // Check status accepted contract
        if($contract->accepted == 0)
            return ['This contract has not yet been accepted.'];

        // Check status complete contract
        if($contract->status_complete == 1)
            return ['This trip has already been completed and your credits granted.'];

        // Check ship fuel
        $ship = Ship::find($contract->payload);
        $fuelShip = $this->shipsAvailable[$contract->origin_planet . '-' . $contract->destination_planet];
        if($ship->fuel_level < $fuelShip)
            return ['The ship does not have enough fuel for this trip. Replenishment is needed.'];

        // Get pilot and check location
        $pilot = Pilot::find($contract->pilot_id);
        if($pilot->location_planet != $contract->origin_planet)
            return ['This pilot is not on the origin planet. Check if there are any other trips to the origin planet'];

        // Update status complete contract
        $contract->status_complete = 1;
        $contract->save();

        // Pay pilot credits
        $pilot = Pilot::find($contract->pilot_id);
        $pilot->credits += $contract->value;
        $pilot->location_planet = $contract->destination_planet;
        $pilot->save();

        // Consume fuel
        $ship = Ship::find($contract->payload);
        $ship->fuel_level -= $fuelShip;
        $pilot->save();

        // Register payment in log
        Report::create(['description' => $contract->description . ' paid ' . $contract->value]);

        return ['Contract completed and payment made.'];
    }
}
