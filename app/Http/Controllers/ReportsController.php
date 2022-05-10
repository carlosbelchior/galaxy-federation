<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Pilot;
use App\Models\Planet;
use App\Models\Report;
use App\Models\Resource;
use App\Models\Router;
use App\Models\Ship;
use App\Models\Travel;

class ReportsController extends Controller
{
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

        $planets = Planet::all();

        // Get contracts and resources by pilot
        foreach($planets as $planet)
        {

            // Get all contracts by planet (sent)
            $contracts_sent = Contract::select('id')->where('origin_planet', $planet->name)->where('status_complete', 1)->get();

            // Get all contracts by planet (received)
            $contracts_received = Contract::select('id')->where('destination_planet', $planet->name)->where('status_complete', 1)->get();

            // Check exist data
            if($contracts_sent->isEmpty())
                array_push($resources_planets[$planet->name]['sent'], 'No data available');

            if($contracts_received->isEmpty())
                array_push($resources_planets[$planet->name]['received'], 'No data available');

            // Get resources by planet (sent)
            if(!$contracts_sent->isEmpty())
            {
                $resources_sent = Resource::selectRaw('name, sum(weight) as total_weight')
                ->groupBy('name')
                ->whereIn('contract_id', $contracts_sent)
                ->get();
                foreach($resources_sent as $resource)
                    array_push($resources_planets[$planet->name]['sent'], [$resource->name => $resource->total_weight]);
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
                    array_push($resources_planets[$planet->name]['received'], [$resource->name => $resource->total_weight]);
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
            return 'No data available.';

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
        // Get all transactions
        $result = Report::select('description')->orderBy('created_at', 'desc')->get();

        // Check no data
        if($result->isEmpty())
            return 'No data available.';

        // Show data
        return $result;
    }

    // Return all pilots
    public function pilots()
    {
        // Get all pilots
        $pilots = Pilot::all();

        // Check no data
        if($pilots->isEmpty())
            return 'No data available.';

        // Show data
        return $pilots;
    }

    // Return all ships
    public function ships()
    {
        // Get all ships
        $ships = Ship::all();

        // Check no data
        if($ships->isEmpty())
            return 'No data available.';

        // Show data
        return $ships;
    }

    // Return all travels
    public function travels()
    {
        // Get all travels
        $travels = Travel::all();

        // Check no data
        if($travels->isEmpty())
            return 'No data available.';

        // Show data
        return $travels;
    }

    // Return all routers available
    public function routers()
    {
        // Get all routers
        return Router::all();
    }

    // Return all routers available
    public function contracts()
    {
        // Get all contracts
        $contracts = Contract::with(['pilot', 'ship'])->where('status_complete', 1)->get();

        // Check no data
        if($contracts->isEmpty())
            return 'No data available.';

        // Show data
        return $contracts;
    }

    // Return all contracts from pilot
    public function contracts_pilot($pilot)
    {
        // Check pilot
        $pilot = Pilot::where('pilot_certification', $pilot)->first();
        if(!$pilot)
            return 'Pilot not found.';

        // Get all contracts
        $contracts = Contract::where('pilot_id', $pilot->id)->get();

        // Check no data
        if(!$contracts)
            return 'No data available.';

        // Show data
        return $contracts;
    }
}
