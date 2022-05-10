<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Report;
use App\Models\Resource;
use App\Models\Travel;

class ReportsController extends Controller
{
    // Planets
    private $planets = array(1 => 'Andvari', 2 => 'Demeter', 3 => 'Aqua', 4 => 'Calas');

    /*
     * This above data can be easily transferred to a database, annotated task for system v2
     */

    // Return resources by planet
    public function resourcePlanet()
    {
        // Check qty contracts
        if(Contract::all()->count() < 1)
            return ['No data available.'];

        // Array data resources planets
        $resources_planets = [
            'Andvari' => [
                'sent' => [],
                'received' => []
            ],
            'Demeter' => [
                'sent' => [],
                'received' => []
            ],
            'Aqua' => [
                'sent' => [],
                'received' => []
            ],
            'Calas' => [
                'sent' => [],
                'received' => []
            ],
        ];

        // Get contracts and resources by pilot
        foreach($this->planets as $planet)
        {

            // Get all contracts by planet (sent)
            $contracts_sent = Contract::select('id')->where('origin_planet', $planet)->where('status_complete', 1)->get();

            // Get all contracts by planet (received)
            $contracts_received = Contract::select('id')->where('destination_planet', $planet)->where('status_complete', 1)->get();

            // Check exist data
            if($contracts_sent->isEmpty())
                array_push($resources_planets[$planet]['sent'], 'No data available');

            if($contracts_received->isEmpty())
                array_push($resources_planets[$planet]['received'], 'No data available');

            // Get resources by planet (sent)
            if(!$contracts_sent->isEmpty())
            {
                $resources_sent = Resource::selectRaw('name, sum(weight) as total_weight')
                ->groupBy('name')
                ->whereIn('contract_id', $contracts_sent)
                ->get();
                foreach($resources_sent as $resource)
                    array_push($resources_planets[$planet]['sent'], [$resource->name => $resource->total_weight]);
            }

            // Get resources by planet (sent)
            if(!$contracts_received->isEmpty())
            {
                // Get resources by planet (received)
                $resources_received = Resource::selectRaw('name, sum(weight) as total_weight')
                ->groupBy('name')
                ->whereIn('contract_id', $contracts_received)
                ->get();
                foreach($resources_received as $resource)
                    array_push($resources_planets[$planet]['received'], [$resource->name => $resource->total_weight]);
            }

        }

        // Return data
        return $resources_planets;
    }

    // Return resources by pilot
    public function resourcePilot()
    {
        // Check qty contracts
        if(Contract::all()->count() < 1)
            return ['No data available!'];

        // Array data resources pilots
        $resources_pilots = [];

        // Get all pilots
        $pilots = Pilot::all();

        // Get contracts and resources by pilot
        foreach($pilots as $pilot)
        {
            $resources_pilots[$pilot->name] = [];
            // Get contracts pilot
            $contracts = Contract::select('id')->where('pilot_id', $pilot->id)->where('status_complete', 1)->get();
            //Sum total resources
            $total_resources = Resource::selectRaw('sum(weight) as weight')
            ->whereIn('contract_id', $contracts)
            ->groupBy('contract_id')
            ->get();
            // Get resources by pilot
            $resources = Resource::selectRaw('name, sum(weight) as weight')
            ->groupBy('name')
            ->whereIn('contract_id', $contracts)
            ->get();

            //Calculate percentage by resource
            $percentage = 0;
            foreach($resources as $resource)
            {
                $percentage = ($resource->weight / $total_resources[0]->weight) * 100;
                array_push($resources_pilots[$pilot->name], [$resource->name => $percentage]);
            }

        }

        // Return data
        return $resources_pilots;
    }

    // Return all transactions
    public function transactions()
    {
        // Get all logs
        $result = Report::select('description')->orderBy('created_at', 'desc')->get();

        // Check no data
        if($result->isEmpty())
            return ['No data available!'];

        // Show data
        return $result;
    }
}
