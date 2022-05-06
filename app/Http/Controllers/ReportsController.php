<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use App\Models\Report;
use App\Models\Resource;
use App\Models\Travel;

class ReportsController extends Controller
{
    // Planets
    private $planets = array(1 => 'Andvari', 2 => 'Demeter', 3 => 'Aqua', 4 => 'Calas');

    // Return resources by planet
    public function resourcePlanet()
    {
        // Check qty travels
        if(Travel::all()->count() < 1)
            return ['No data available.'];
    
        // Array data resources planets
        $resources_planets = [];

        // Get travels and resources by pilot
        foreach($this->planets as $planet)
        {
            
            // Get all travels by planet (sent)
            $travels_sent = Travel::select('id')->where('origin_planet', $planet)->get();
    
            // Get all travels by planet (received)
            $travels_received = Travel::select('id')->where('destination_planet', $planet)->get();

            // Check exist data
            if($travels_sent->isEmpty())
                $resources_planets[$planet].push(['sent' => 'No data available']);

            if($travels_received->isEmpty())
                $resources_planets[$planet].push(['received' => 'No data available']);

            // Get resources by planet (sent)
            if(!$travels_sent->isEmpty())
            {
                $resources_sent = Resource::selectRaw('name, sum(weight) as total_weight')
                ->groupBy('name')
                ->whereIn('contract_id', $travels_sent)
                ->get();
                $resources_planets[$planet].push(['sent' => $resources_sent]);
            }

            // Get resources by planet (sent)
            if(!$travels_received->isEmpty())
            {
                // Get resources by planet (received)
                $resources_received = Resource::selectRaw('name, sum(weight) as total_weight')
                ->groupBy('name')
                ->whereIn('contract_id', $travels_received)
                ->get();
                $resources_planets[$planet].push(['received' => $resources_received]);
            }
            
        }
        
        // Return data
        return $resources_planets;
    }

    // Return resources by pilot
    public function resourcePilot()
    {
        // Check qty travels
        if(Travel::all()->count() < 1)
            return ['No data available!'];
    
        // Array data resources pilots
        $resources_pilots = [];

        // Get all pilots
        $pilots = Pilot::all();
    
        // Get travels and resources by pilot
        foreach($pilots as $pilot)
        {
            // Get travels pilot
            $travels = Travel::select('id')->where('pilot_id', $pilot->id)->get();
            //Sum total resources
            $total_resources = Resource::selectRaw('sum(weight) as total_weight')
            ->whereIn('contract_id', $travels)
            ->get();
            // Get resources by pilot
            $resources = Resource::selectRaw('name, sum(weight) as total_weight')
            ->groupBy('name')
            ->whereIn('contract_id', $travels)
            ->get();
            
            //Calculate percentage by resource
            $percentage = 0;
            foreach($resources as $resource)
            {
                $percentage = ($resource->total_weight / $total_resources->total_weight) * 100;
                $resources_pilots[$pilot->name] = [
                    $resources->name => $percentage
                ];
            }
            
        }
        
        // Return data
        return $resources_pilots;
    }

    // Return all transactions
    public function transactions()
    {
        // Get all logs
        $result = Report::orderBy('created_at', 'desc')->get();
    
        // Check no data
        if($result->isEmpty())
            return ['No data available!'];

        // Show data
        return $result;
    }
}
