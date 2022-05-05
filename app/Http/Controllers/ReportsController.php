<?php

namespace App\Http\Controllers;

use App\Models\Report;

class ReportsController extends Controller
{
    // Return all transactions
    public function all()
    {
        $result = Report::all();
    
        if($result->isEmpty())
            return ['No data available!'];

        return $result;
            
    }
}
