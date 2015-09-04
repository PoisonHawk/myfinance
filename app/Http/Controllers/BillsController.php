<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use App\Currency;
use Illuminate\Support\Facades\Validator;
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
        $bills = Bills::with('currency')->userBills();
         
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
        $ans = ['status' =>'ok'];
        
        $messages = [
            'required' => 'Поле должно быть заполнено',
            'numeric' => 'Значение должно быть числом',
        ];
        
        $this->validate($request, [
                'name' => 'required',
                'amount' => 'required|numeric',  
        ], $messages);
        
//        $validator = Validator::make($request->all(), [
//                'name' => 'required',
//                'amount' => 'required|numeric',                
//            ], $messages
//        );
//        
//        if ($validator->fails()) {
//            
//            $errors = $validator->messages();
//            
//            
//            $ans['status'] = 'fail';
//            $ans['errors'] = $validator->messages();
//            $ans['faild'] = $validator->failed();
//                        
//            return json_encode($ans);
//            
//        }
      
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['active'] = 1;
        
        $newBill = Bills::create($input);
        
        $bill = Bills::with('currency')->find($newBill->id);
        
        $ans['bill'] = $bill;   
        return json_encode($ans);
        
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
        
        $bill->active = 0;
        
        try{
            $bill->save();
        } catch (Exception $e) {
            abort(500);
            $ans = ['status' => 'fail', 'message' => 'Ошибка операции'];
        
            return json_encode($ans);
        }
                        
        $ans = ['status' => 'ok', 'message' => 'Счет успешно удален'];
        
        return json_encode($ans);
        
//        Session::flash('flash_message', 'Счет успешно удален');
//        
//        return redirect(route('bills.index'));
    }
}
