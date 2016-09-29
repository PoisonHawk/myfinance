<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use Auth;

class IndexController extends Controller
{
    
    public function home(){
         
        return view('index.home', ['user_bills'=> Bills::reportBills(),]);
    }
    
    public function token(){
        return csrf_token();
    }
}
