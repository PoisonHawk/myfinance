<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Operation;
use App\Bills;

class IndexController extends Controller
{
    public function home(){
        
        $data = [
            'user_bills'=> Bills::reportBills(),
            'userOucomesToday' => Operation::outcomeToday(),
        ];
        
        return view('index.home', $data);
    }
    
}
