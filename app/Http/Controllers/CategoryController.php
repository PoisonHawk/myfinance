<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;
use Baum;

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
        
        $categories = Category::select('id', 'name', 'parent_id')
                ->where('type', '=', 'outcome')
                ->where('user_id','=',Auth::user()->id)
                ->get()
                ->toHierarchy();
        
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
                        
        $cat = Category::where('type', '=', $type)
                ->where('user_id','=',Auth::user()->id)
                ->get()
                ->toHierarchy();
                                     
        //todo вынести в рекурсию!!!
        $categories = ['0' => 'Корневая'];
        foreach($cat as $c) {
            $categories[$c->id] = $c->name;            
            if( isset($c->children) ) { 
                foreach($c->children as $cat_ch) {
                    $categories[$cat_ch->id] = '--'.$cat_ch->name;
                }
            }
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
        
        if ($input['parent_id'] == 0) {
            Category::create($input);
        } else {
            
            $child = Category::create($input);            
            $root = Category::findOrFail($input['parent_id']);
            $child->makeChildOf($root);
            
        }
                
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
