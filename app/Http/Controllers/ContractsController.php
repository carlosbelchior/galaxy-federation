<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Report;
use App\Models\Router;
use App\Models\Ship;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    // Ships available
    private $routersAvailable = array(
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

    /*
     * This above data can be easily transferred to a database, annotated task for system v2
     */

    // List all open contracts
    public function all()
    {
        /* Get all open contracts
        *  Status: 0 is open, 1 is closed
        */
        $result = Contract::where('status_complete', 0)->orderBy('created_at')->get();

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

        if(!$contract)
        return response()->json([
            'Contract not found.'
        ], 400);

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
    public function finish($id)
    {
        // Get contract
        $contract = Contract::find($id);

        if(!$contract)
        return response()->json([
            'Contract not found.'
        ], 400);

        // Check status accepted contract
        if($contract->accepted == 0)
            return ['This contract has not yet been accepted.'];

        // Check status complete contract
        if($contract->status_complete == 1)
            return ['This trip has already been completed and your credits granted.'];

        $ship = Ship::find($contract->ship_id);
        $pilot = Pilot::find($contract->pilot_id);

        // Check ship fuel
        $fuelRouter = Router::getRouter($contract->origin_planet, $contract->destination_planet);
        if($ship->fuel_level < $fuelRouter->coust)
            return ['The ship does not have enough fuel for this trip. Replenishment is needed.'];

        // Get pilot and check location
        if($pilot->location_planet != $contract->origin_planet)
            return ['This pilot is not on the origin planet. Check if there are any other trips to the origin planet'];

            // Get pilot and check location
        if($ship->location_planet != $contract->origin_planet)
            return ['This ship is not on the origin planet. Check if there are any other trips to the origin planet'];

        // Update status complete contract
        $contract->status_complete = 1;
        $contract->save();

        // Pay pilot credits
        $pilot->credits += $contract->value;
        $pilot->location_planet = $contract->destination_planet;
        $pilot->save();

        // Consume fuel
        $ship->fuel_level -= $fuelRouter->coust;
        $ship->location_planet = $contract->destination_planet;
        $ship->save();

        // Register payment in log
        Report::create(['description' => $contract->description . ' paid: -₭' . $contract->value]);

        return ['Contract completed and payment made.'];
    }
}
