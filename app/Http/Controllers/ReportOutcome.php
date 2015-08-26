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
    
    public function getIndex(){
        
        $op = new Operation();
        
        $data = $op->outcomes('outcome');
        
        return view('reports.outcomes', $data);
    }
    
    /**
     * Расходы за текущий месяц
     * @todo добавить фильтры по врпемени
     * @return json
     */
    public function getOutcome(){
        
        $op = new Operation();
        
        $data = $op->outcomes('outcome');
        
        return json_encode($data);
    }
    
    /**
     * Отчет по доходам за текущий месяц
     * @todo добавить фильтры по времени
     * @return json
     */
    public function getIncome(){
        
        $op = new Operation();
        
        $data = $op->outcomes('income');
        
        return json_encode($data);
    }
    
}
