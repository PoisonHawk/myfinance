<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use App\Currency;
use Session;
use Auth;

class BillsController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bills::userBills();
         
        $cur = new Currency();
        $currency = $cur->allCurrencies();   
        
        $data = [
            'bills' => $bills,
            'currency' => $currency,
        ];
        
        return $data;
        
        //return view('bills.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @todo не используется, проверить и удалть
     * @return Response
     */
    public function create()
    {
        $cur = new Currency();
        $currency = $cur->allCurrencies();        
        
        return view('bills.create')->with('currency', $currency);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        
        //todo дописать правила валидации
        
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'numeric',
        ]);
           
               
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        
        $bill = Bills::create($input);
        
        
        //todo возврат ошибки в случае чего
        
        return $bill;
        
//        Session::flash('flash_message', 'Новый счет успешно добавлен');
//                
//        return redirect(route('bills.index'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $bill = Bills::findOrFail($id);
        
        return view('bills.edit')->with('bill', $bill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $bill = Bills::findOrFail($id);
        
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'numeric',
        ]);
                          
        $bill->fill($request->all())->save();
                    
        $ans = [
            'status'=> 'ok',
            'bill' => $bill,
            'message' => 'Cчет отредактирован',
        ];
        
        return json_encode($ans);
        
//        Session::flash('flash_message', 'Cчет отредактирован');
//        
//        return redirect(route('bills.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $bill = Bills::findOrFail($id);
        
        $bill->delete();
                
        $ans = ['status' => 'ok', 'message' => 'Счет успешно удален'];
        
        return json_encode($ans);
        
//        Session::flash('flash_message', 'Счет успешно удален');
//        
//        return redirect(route('bills.index'));
    }
}
