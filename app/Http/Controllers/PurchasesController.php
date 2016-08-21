<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Purchase;
use Auth;
use App\Category;
use Response;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $categories = [];

    public function __construct(){

      $category = Category::where('user_id','=', Auth::user()->id)
              ->where('type' ,'=', 'outcome')
             ->get()
             ->toHierarchy();

      $categories = [];
      foreach($category as $c) {
          $categories[$c->id] = $c->name;
          if( isset($c->children) ) {
              foreach($c->children as $cat_ch) {
                  $categories[$cat_ch->id] = '&nbsp;&nbsp;&nbsp;&nbsp;'.$cat_ch->name;
              }
          }
      }

      $this->categories = $categories;
    }


    public function index()
    {

        $purchases = Purchase::where('user_id', Auth::user()->id)
              ->orderBy('priority', 'desc')
              ->orderBy('amount', 'desc')
               ->orderBy('name', 'desc')
               ->get();

        return view('purchases.index', ['purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      return view('purchases.create', ['categories'=> $this->categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());

        $validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'amount' => 'numeric',

        ]);

        if($validator->fails()){
          return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $purchase = new Purchase();

        $purchase->user_id = Auth::user()->id;
        $purchase->name = $request->input('name');
        $purchase->amount = $request->input('amount')?:0;
        $purchase->category_id = $request->input('category_id');
        $purchase->priority = $request->input('priority');

        $purchase->save();

        return redirect('/purchase');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $purchase = Purchase::find($id);

        if (!$purchase) {
          return redirect()
            ->back()
            ->withErrors(['Операция не найдена']);
        }

        return view('purchases.edit', [
          'purchase' => $purchase,
          'categories' => $this->categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $purchase = Purchase::find($id.'111');

      if (!$purchase) {
        return redirect()
          ->back()
          ->withErrors(['Невозможно внести изменения. Попробуйте позже.']);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'amount' => 'numeric',
      ]);

      if($validator->fails()){
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }

      $purchase->name = $request->input('name');
      $purchase->amount = $request->input('amount')?:0;
      $purchase->category_id = $request->input('category_id');
      $purchase->priority = $request->input('priority');

      $purchase->save();

      return redirect('/purchase');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $purchase = Purchase::find($id);

      $success = true;

      if (!$purchase) {

        return Response::json(['status'=>false, 'error' => 'Невозможно удалить запись. Попробуйте позже']);

      }

      $purchase->delete();

      return Response::json(['status'=>true]);

    }
}
