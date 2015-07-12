<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bills;
use Session;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bills::all();
        
        return view('bills.index')->with('bills', $bills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('bills.create');
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
        
        Bills::create($input);
        
        Session::flash('flash_message', 'Новый счет успешно добавлен');
        
        return redirect(route('bills.index'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
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
                       
        Session::flash('flash_message', 'Cчет отредактирован');
        
        return redirect(route('bills.index'));
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
        
        Session::flash('flash_message', 'Счет успешно удален');
        
        return redirect(route('bills.index'));
    }
}
