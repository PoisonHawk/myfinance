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
        
        
        $res = DB::table('operations')
                ->join('categories', 'operations.category_id', '=', 'categories.id')
                ->select('categories.name', 'categories.parent_id', 'operations.amount')
                ->where('operations.user_id', '=', Auth::user()->id)
                ->where('operations.type','=','outcome')
                ->get();            
//          dd($res);       
       
        
        $result = [];
        
        $total = 0;
        
        foreach($res as $r) {
            
            if ($r->parent_id == 0 ) {
                
                $cat = $r->name;                
                
            } else {
                $cat = Category::find($r->parent_id)->name;
            }
            
            if (!isset($result[$cat])) {
                $result[$cat] = [
                    'total' => 0,
                    'items' => [],
                ];
            }
            
            $result[$cat]['items'][$r->name] = $r->amount; 
            $result[$cat]['total'] += $r->amount;
            $total += $r->amount; 
        }
        
        dd($result);
        
        return 'Report';
    }
    
}
