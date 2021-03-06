<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use Auth;
use App\Purchase;
use App\Operation;
use App\Category;
use App\Credit;

class IndexController extends Controller
{
    
    public function home(){
		
        $purchases = Purchase::where('priority', '=', 4)
            ->where('user_id', '=', Auth::user()->id)
            ->limit(10)
            ->get();

        return view('index.home', [
			'user_bills'=> Bills::reportBills(), 
			'purchases' => $purchases,
			'operationReports' => json_encode(Operation::YearOperationReport(), true),
			'topCategories' => Category::topCategoryReport(),
			'dayWeekMonthStat' => Operation::dayWeekMonthStat(),
            'credits' => Bills::getDebts()
			]);
    }
    
    public function token(){
        return csrf_token();
    }
}
