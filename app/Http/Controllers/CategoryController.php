<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function income(){
                
        
        $categories = Category::where('type', '=', 'income')->where('user_id','=',Auth::user()->id)->get();
        
        
        $data = [
            'type' => 'income',
            'cat_name' => 'Доходы',
            'categories' => $categories,
        ];
        
        return view('category.index', $data);;
    }
    
    public function outcome(){
        
        $categories = Category::select('id', 'name', 'parent_id')->where('type', '=', 'outcome')->where('user_id','=',Auth::user()->id)->get()->toArray();

//        dd($categories);
        
        $cat = [];
        $cat_id = [];
        foreach ($categories as $c) {
//            $cat[$c['parent_id']][] = $c;
            $cat_ID[$c['id']][] = $c;
            $cat[$c['parent_id']][$c['id']] =  $c;
        }
        
        dd($cat_ID);
        
        $data = [
            'type' => 'outcome',
            'cat_name' => 'Расходы',
            'categories' => $categories,
            'cat' => $cat,
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
                        
        $cat = Category::select('id', 'name')->where('type', '=', $type)->get()->toArray();
               
        $categories = ['0' => 'Корневая'];
        foreach($cat as $c) {
            $categories[$c['id']] = $c['name'];
        }
        
        $data = [
            'categories' => $categories,
            'type' => $type,
        ];
        
        return view('category.create', $data);
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
        $input['user_id'] = Auth::user()->id;
        
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
