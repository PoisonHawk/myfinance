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
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        
        $data = Operation::outcomes();
        
        return view('reports.outcomes', $data);
    }
    
}
