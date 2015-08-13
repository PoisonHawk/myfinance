<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use App\Category;
use App\Operation;
use Session;
use DB;
use Carbon\Carbon;
use Auth;

class OperationsController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $req)
    {          
              
        $startOfMonth   = mktime(0,0,0, date('m', time()), 1, date('Y', time()));                 
        
        $default_from   = date('d.m.Y', $startOfMonth);
        $default_to     = date('d.m.Y', time()+24*60*60);
               
        $from_date      = $req->input('from_date', $default_from);
        $to_date        = $req->input('to_date', $default_to);
      
        $temp = explode('.', $from_date);
        $from = implode('-', array_reverse($temp));
        
        $temp = explode('.', $to_date);
        $to = implode('-', array_reverse($temp));
        
        $operations = Operation::where('created', '>=', $from)
                ->where('created', '<=', $to)
                ->where('user_id', '=', Auth::user()->id);
        
        $bill = $req->input('bill');   
        
        if ($bill !=0) {           
            $operations = $operations->where('bills_id', '=', $bill);
        }
        
        $operations = $operations->orderBy('created', 'desc')->get();
         
        //получаем список счетов        
        $bills = array('0' => 'Все');
        
        foreach(Bills::where('user_id','=', Auth::user()->id)->get() as $b) {
            $bills[$b->id] = $b->name;
        }               
                
        $data = array(
            'operations' => $operations,
            'to_date' => $to_date,
            'from_date' => $from_date,
            'bills' => $bills,
            'bill' => $bill,
            
        );        
        
        return view('operations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $req)
    {
        
       $type = $req->input('type'); 
           
       $bills = Bills::where('user_id','=', Auth::user()->id)->get(); 
       
       $category = Category::where('type', '=', $type)
               ->where('user_id','=', Auth::user()->id)
               ->get();
        
       $data = [
           'today' => date('Y-m-d H:i', time()),
           'bills' => $bills,
           'category' => $category,
           'type' => $type,
           
           ];
       
                        
       return view('operations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $req)
    {
  
        //todo добавить правила валидации
        
        $this->validate($req,[
            'amount' => 'required|numeric',
        ]);
        
        
        $bill_id    = $req->input('bills_id');
        $amount     = $req->input('amount');
        $type       = $req->input('type');
        
        $bill = Bills::find($bill_id);
        
        //todo проверка на существование
        
        $amount = str_replace(',','.',$amount);
        
        if ($type == 'outcome' and floatval($bill->amount) < floatval($amount)) {            
            return redirect()->back()->with('flash_error', 'Недостаточно средств на счете' );
        }
       
        if ($req->input('created') > Carbon::now()) {            
            return redirect()->back()->with('flash_error', 'Время операции больше текущей');
        }
        
        $op = new Operation();
        $op->operationTransact($req->input());
        
        return redirect(route('operations.index'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $op = Operation::findOrFail($id);
                
        $bills = Bills::where('user_id','=', Auth::user()->id)->get(); 
       
        $cat = Category::select('id', 'name')
                ->where('type', '=', $op->type)
                ->where('user_id','=', Auth::user()->id)
                ->get()
                ->toArray();
        
        $category = array();

        foreach($cat as $c) {
            $category[$c['id']] = $c['name'];
        }
        
        $data = [           
           'bills' => $bills,
           'category' => $category,
           'type' => $op->type,
           'op' => $op, 
           ];
        
        return view('operations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $req)
    {
       
        //todo добавить правила валидации
        
        $this->validate($req,[
            'amount' => 'required|numeric',
        ]);
        
        $op = Operation::find($id);
        
        $bill_id    = $req->input('bills_id');
        $amount     = $req->input('amount');
        $type       = $req->input('type');
        
        $bill = Bills::find($bill_id);
        
        //todo проверка на существование
        
        $amount = str_replace(',','.',$amount);
        
        if ($type == 'outcome' and floatval($bill->amount) < floatval($amount)) {
            Session::flash('flash_error', 'Не достаточно средств на счете');
            return redirect()->back();
        }
       
        if ($req->input('created') > Carbon::now()) {
            Session::flash('flash_error', 'Время операции больше текущей');
            return redirect()->back();
        }
                 
        $op->operationTransact($req->input());
        
        return redirect(route('operations.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $op = Operation::findOrFail($id);
        
        $bill = Bills::findOrFail($op->bills_id);       
        
        $amount  = $op->type == 'income' ? -$op->amount : $op->amount;
        
        
        DB::beginTransaction();
        
        try{
            
            $bill->amount =$bill->amount + $amount;
            $bill->save();
            
            $op->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            
        }
        
        DB::commit();    
        Session::flash('flash_message', 'Операция успешно удалена');
        
        return redirect(route('operations.index'));
    }
            
    /**
     * Отмена операции
     * @param int $id
     * @return Response
     */
    public function cancel($id) {
               
        $ans = ['status' => 'failed', 'error' => '']; 
                        
        $op = Operation::findOrFail($id);
        
        if (!$op) {
            return;
        }
        
        if ($op->active == 0) {
            return;
        }
        
        $amount = $op->type == 'outcome' ? $op->amount : -$op->amount;
          
        try {
            $op->bill->amount = $op->bill->amount + $amount;
            $op->bill->save();
            
            $op->active = 0;
            $op->save();
            
        } catch (Exception $e) {
            $ans['error'] = $e->getMessage();
            return response(json_encode($ans));
        }
        
        $ans['status'] = 'ok';
        
        return response(json_encode($ans));

    }
}
