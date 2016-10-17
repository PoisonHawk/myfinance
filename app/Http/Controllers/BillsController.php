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
            'numeric' => 'Значение должно быть числом',
        ];

        $this->validate($request, [
                'name' => 'required',
                'amount' => 'required|numeric',
				'saving_amount' => 'numeric',
        ], $messages);
		
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['active'] = 1;
		
        if ($request->input('default_wallet')==1){
			Bills::where('default_wallet',1)->update(['default_wallet'=>0]);
		}

        $newBill = Bills::create($input);

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
            $bill->save();
        } catch (Exception $e) {
            abort(500);
            $ans = ['status' => 'fail', 'message' => 'Ошибка операции'];

            return json_encode($ans);
        }

        $ans = ['status' => 'ok', 'message' => 'Счет успешно удален'];

        return json_encode($ans);

    }
}
