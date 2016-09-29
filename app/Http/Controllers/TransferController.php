<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Bills;
use App\Operation;
use App\Transfer;
use Auth;
use DB;

class TransferController extends Controller
{
    
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
        
        $transfers = Transfer::where('user_id','=',Auth::user()->id)
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->orderBy('created_at', 'desc')
                ->get();
        
       
        
        $data =[
            'transfers' => $transfers,
            'to_date' => $to_date,
            'from_date' => $from_date,
        ];
        
        return view('transfers.index', $data);
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
        
        $input = $req->input();
        $input['user_id'] = Auth::user()->id;
        
        DB::beginTransaction();
        try {
        //запись в трансферс            
            $transfer = Transfer::create($input);

            $pk = $transfer->id;
            
            $billFrom->amount -= $amount;
            $billFrom->save();
            
            $billTo->amount += $amount;
            $billTo->save();
            
			//todo нужны ли записи в operations?
			//
            //запись в operations
//            $op = new Operation();
//            $op->created = $transfer->created_at;
//            $op->user_id = Auth::user()->id;
//            $op->bills_id = $bill_from_id;
//            $op->type = 'transfer_out';
//            $op->amount = $amount;
//            $op->transfer_id = $transfer->id;
//            $op->active = 1;
//            $op->save();
//            
//            $op = new Operation();
//            $op->created = $transfer->created_at;
//            $op->user_id = Auth::user()->id;
//            $op->bills_id = $bill_to_id;
//            $op->type = 'transfer_in';
//            $op->amount = $amount;
//            $op->transfer_id = $transfer->id;
//            $op->active = 1;
//            $op->save();

        } catch (Exception $e) {
            
            DB::rollBack();
            throw new Exception ($e->getMessage());
            
        }
       
        DB::commit();
        
        $url = $req->input('redirect');
        if ($url) {
            return redirect($url);
        }
        
        return redirect(route('transfers.index'));
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
        
        //todo если не существует запись
        
        $transfer = Transfer::findOrFail($id);        
        
        DB::beginTransaction();
        
        try{            
        
            //изменить балансы
            $transfer->billFrom->amount += $transfer->amount;
            $transfer->billFrom->save();

            $transfer->billTo->amount -= $transfer->amount;
            $transfer->billTo->save();
            
            //удалить связанные операции
            $transfer->operations()->delete();
            
            //удалить запись
            $transfer->delete();
        
        } catch  (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        
        DB::commit();
        
        return redirect(route('transfers.index'))->with('flash_message', 'Операция успешно удалена');
        
    }
}
