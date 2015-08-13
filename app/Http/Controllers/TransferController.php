<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Bills;
use App\Operations;
use Auth;

class TransferController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {       
        
        $bills = Bills::select('id', 'name')->where('user_id', '=', Auth::user()->id)->get()->toArray();
        
        $b= [];
        foreach($bills as $bill){
            $b[$bill['id']] = $bill['name'];
        }
        
        
        $data = [
            'today' => Carbon::now(),
            'bills' => $b,
        ];
        
        return view('transfers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $req)
    {
        
        //todo добавить правила валидации
        
        $this->validate($req,[
            'amount' => 'required|numeric',
        ]);
        
        
        $bill_from_id   = $req->input('bill_from_id');
        $bill_to_id     = $req->input('bill_to_id');
        $amount         = $req->input('amount');        
        
        $billFrom = Bills::find($bill_from_id);
        $billTo = Bills::find($bill_to_id);
                
        if ($bill_from_id == $bill_to_id) {
            return redirect()->back()->with('flash_error', 'Нельзя сделать перемещение на тот же счет' );
        }
        
        //todo проверка на существование
        
        $amount = str_replace(',','.',$amount);
        
        if (floatval($billFrom->amount) < floatval($amount)) {            
            return redirect()->back()->with('flash_error', 'Недостаточно средств на счете' );
        }
       
        if ($req->input('created') > Carbon::now()) {            
            return redirect()->back()->with('flash_error', 'Время операции больше текущей');
        }
        
        //запись в трансферс
        $transfer = Transfer();
        
        $transfer::create($req->input());
        
        $pk = $transfer->pk();
        
        //запись в operations
        
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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
