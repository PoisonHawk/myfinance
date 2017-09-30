<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Bills;
use App\Currency;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth;

class BillsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bills::with('currency')->orderBy('id')->userBills();

        $cur = new Currency();
        $currency = $cur->allCurrencies();

        $data = [
            'bills' => $bills,
            'currency' => $currency,
        ];

        return $data;

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
        ];

        $this->validate($request, [
                'name' => 'required',
                'amount' => 'required',				
        ], $messages);
		
		$amount = $request->input('amount');
		$saving_amount = $request->input('saving_amount');
		
		$amount = str_replace(',','.',$amount);		
		$saving_amount = str_replace(',','.',$saving_amount);
		
		if (!is_numeric($amount) ) {  
			return Response::json(['amount' => ['Неверный формат суммы']
				], 422);
        }
		
		if ( $amount <= 0 ) {  
			return Response::json(
					['amount'   =>  ['Сумма должна быть положительным числом']
				], 422);
        }		
		
		if (!is_numeric($saving_amount) ) {  
			return Response::json([                
                    'saving_amount'   =>  ['Неверный формат суммы'],
                ], 422);
        }
		
		if ( $saving_amount < 0 ) {  
			return Response::json([                    
                    'saving_amount'   =>  ['Сумма должна быть положительным числом'] ,
                ], 422);
        }	
		
        $input = $request->all();       
		
		//если выбираем счет по умолчанию, то обнуляем прежний
        if ($request->input('default_wallet')==1){
			Bills::where('default_wallet',1)->update(['default_wallet'=>0]);
		}
		
		try{
			$newBill = new Bills;
			$newBill->user_id = Auth::user()->id;
			$newBill->name = $input['name'];
			$newBill->amount = round($amount,2);
			$newBill->currency_id = $input['currency_id'];			
			$newBill->active = 1;
			$newBill->default_wallet = $input['default_wallet'];	
			$newBill->show = $input['show'];
			$newBill->saving_account = $input['saving_account'];
			$newBill->saving_amount = round($input['saving_amount'],2);
            $newBill->credit = $input['credit'];
			
			$newBill->save();
			
		} catch( \Exception $e) {
//            throw new \Exception($e->getMessage());
			return Response::json([
                    'main'   =>  ['Извините, произошла ошибка. Обратитесь в тех поддержку.'] ,
                ], 422);
		}
		
        $bill = Bills::with('currency')->find($newBill->id);

        $ans['bill'] = $bill;
        return json_encode($ans);

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

		if ($request->input('default_wallet')==1){
			Bills::where('default_wallet',1)->update(['default_wallet'=>0]);
		}

        $bill->fill($request->all())->save();
        $bill = Bills::with('currency')->find($id);
        $ans = [
            'status'=> 'ok',
            'bill' => $bill,
            'message' => 'Cчет отредактирован',
        ];

        return json_encode($ans);

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
            $bill->saves();
        } catch (\Exception $e) {
            abort(500);            
        }

        $ans = ['status' => 'ok', 'message' => 'Счет успешно удален.'];

        return json_encode($ans);

    }
}
