<?php

namespace App\Http\Controllers;

use App\Models\Report;

class ReportsController extends Controller
{
    // Return all transactions
    public function all()
    {
        // Get all logs
        $result = Report::all();
    
        // Check no data
        if($result->isEmpty())
            return ['No data available!'];

        // Show data
        return $result;
    }
}
