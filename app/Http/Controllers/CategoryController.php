<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function income(){
                
        
        $categories = Category::where('type', '=', 'income')->get();
        
        
        $data = [
            'type' => 'income',
            'cat_name' => 'Доходы',
            'categories' => $categories,
        ];
        
        return view('category.index', $data);;
    }
    
    public function outcome(){
        
        $categories = Category::where('type', '=', 'outcome')->get();
        
        
        $data = [
            'type' => 'outcome',
            'cat_name' => 'Расходы',
            'categories' => $categories,
        ];
        
        
        return view('category.index', $data);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($type='income')
    {               
       $url = url('category/'.$type); 
        
       return redirect($url);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $req)
    {
        $type = $req->input('type');
                
        return view('category.create')->with('type', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $req)
    {
        
        //todo добавить правила валидации
        
        $this->validate($req, [
            'name' => 'required',
        ]);
        
        $input = $req->input();
        
        Category::create($input);
        
        $url = 'category/'.$req->input('type');
        
        return redirect($url);
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
