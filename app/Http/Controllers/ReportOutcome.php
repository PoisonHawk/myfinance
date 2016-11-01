<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Operation;
use Auth;
use DB;
use App\Category;

class ReportOutcome extends Controller
{
    
	public function getReport($type = 'outcomes', Request $req){
        
        $op = new Operation();

        $data = $op->outcomes($type, $req->get('from'), $req->get('to'));
        
        return json_encode($data);
    }	
    
}
