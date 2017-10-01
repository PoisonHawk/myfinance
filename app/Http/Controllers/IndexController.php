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

        $credits = Credit::where('user_id', Auth::id())->orderBy('amount', 'desc')->get();

        $credits = Bills::where('user_id', Auth::id())
            ->where('debt_amount', '>', 0)
            ->orderBy('debt_amount', 'desc')
            ->get();

//        dd($credits);
//         dd(Operation::dayWeekMonthStat());
        return view('index.home', [
			'user_bills'=> Bills::reportBills(), 
			'purchases' => $purchases,
			'operationReports' => json_encode(Operation::YearOperationReport(), true),
			'topCategories' => Category::topCategoryReport(),
			'dayWeekMonthStat' => Operation::dayWeekMonthStat(),
            'credits' => $credits
			]);
    }
    
    public function token(){
        return csrf_token();
    }
}
