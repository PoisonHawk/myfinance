<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;
use Baum;
use Validator;
use DB;

class CategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $req) {

		$type = $req->input('type', 'income');

		$income = Category::select('id', 'name', 'parent_id')
			->where('type', '=', 'income')
			->where('user_id', '=', Auth::user()->id)
			->orderBy('id', 'ASC')
			->get()
			->toHierarchy();

		$outcome = Category::select('id', 'name', 'parent_id')
			->where('type', '=', 'outcome')
			->where('user_id', '=', Auth::user()->id)
			->orderBy('id', 'ASC')
			->get()
			->toHierarchy();

		$catName = [
			'income' => 'Доходы',
			'outcome' => 'Расходы'
		];

		
		$data = [
			'type' => $type,
			'cat_name' => $catName,
			'income' => $income,
			'outcome' => $outcome,
			'categoryReport' => json_encode(Category::CategoryReport(),true),
		];

		return view('category.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $req) {
		$type = $req->input('type');

		$cat = Category::where('type', '=', $type)
				->where('user_id', '=', Auth::user()->id)
				->get()
				->toHierarchy();

		//todo вынести в рекурсию!!!
		$categories = ['0' => 'Корневая'];
		foreach ($cat as $c) {
			$categories[$c->id] = $c->name;
			if (isset($c->children)) {
				foreach ($c->children as $cat_ch) {
					$categories[$cat_ch->id] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $cat_ch->name;
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
	public function store(Request $req) {

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

		$url = 'category?type=' . $req->input('type');

		return redirect($url);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Request $req) {

		$category = Category::find($id);

		if (!$category) {
			abort('500');
		}

		$cat = Category::where('type', '=', $category->type)
				->where('user_id', '=', Auth::user()->id)
				->get()
				->toHierarchy();

		//todo вынести в рекурсию!!!
		$categories = ['0' => 'Корневая'];
		foreach ($cat as $c) {
			$categories[$c->id] = $c->name;
			if (isset($c->children)) {
				foreach ($c->children as $cat_ch) {
					$categories[$cat_ch->id] = "---&nbsp;&nbsp;&nbsp;&nbsp;" . $cat_ch->name;
				}
			}
		}

		$data = [
			'category' => $category,
			'categories' => $categories,
		];

		return view('category.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $req) {

		$category = Category::find($id);

		if (!$category) {
			abort('500');
		}

		$valid = Validator::make($req->input(), [
					'name' => 'required',
		]);

		if ($valid->fails()) {
			return redirect()->back()->withErrors($valid);
		}

		$category->name = $req->input('name');

		if ($req->input('parent_id') == 0) {

			$category->save();

			if ($category->isChild()) {
				$category->makeRoot();
			}
		} else {
			$category->save();

			if ($category->parent_id != $req->input('parent_id')) {
				$root = Category::findOrFail($req->input('parent_id'));
				$category->makeChildOf($root);
			}
		}

		$url = 'category?type=' . $req->input('type');

		return redirect($url);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$category = Category::find($id);

		if (!$category) {
			abort('500');
		}

		$operations = $category->operations;

		DB::beginTransaction();

		try {

			$category->delete();
		} catch (Exception $e) {

			//todo логирование;
			DB::rollback();
			return response()->json(['error' => true, 'text' => 'Невозможно удалить данную категорию. Попробуйте попозже']);
		}


		DB::commit();
		return response()->json([
					'error' => false,
					'text' => 'Ктатегория удалена',
		]);
	}

}
