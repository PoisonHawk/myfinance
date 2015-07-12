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

class OperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $operations = Operation::orderBy('created_at', 'desc')->get();
        
        return view('operations.index')->with('operations', $operations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $req)
    {
        
       $type = $req->input('type'); 
           
       $bills = Bills::all(); 
       
       $category = Category::where('type', '=', $type)->get();
        
       $data = [
           'today' => date('d-m-Y H:i:s', time()),
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
        
        if ($type == 'outcome' and $bill->amount < $amount) {
            Session::flash('flash_error', 'Не достаточно средств на счете');
            return redirect()->back();
        }
        
        
        $amount = $type == 'income' ? $amount : -$amount;
        
        //транзакция
        DB::beginTransaction();
        try{
            Operation::create($req->input());            
            
            $bill->amount = floatval($bill->amount) + floatval($amount);
            $bill->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            DB:rollback();
        }
        
        DB::commit();
        //конец транзакции
        
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
