<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Operation;
use App\Bills;
use App\Category;
use App\Currency;
use Auth;

class IndexController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function home(){
                
        $bills = Bills::userBills(); 
        
        $category = Category::where('user_id','=', Auth::user()->id)
               ->get()
               ->toHierarchy();
                                 
        $categories = [];
        foreach($category as $c) {
            $categories[$c->type][$c->id] = $c->name;            
            if( isset($c->children) ) { 
                foreach($c->children as $cat_ch) {
                    $categories[$c->type][$cat_ch->id] = '--'.$cat_ch->name;
                }
            }
        }       
        //dd($categories);
        $data = [
            'today' => date('Y-m-d H:i', time()),
            'bills' => $bills,
            'categories' => $categories,            
            'user_bills'=> Bills::reportBills(),
            //'userOucomesToday' => Operation::outcomeToday(),
        ];
        
        return view('index.home', $data);
    }
    
    public function token(){
        return csrf_token();
    }
}
