<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Category extends \Baum\Node
{
    public $table = 'categories';
    //
    protected $fillable = [
      'user_id',
        'name',
        'type',
        //'parent_id',
    ];
    
    protected $visible = [
      'name',  
    ];
    
    public function user(){
        $this->belongsTo('user');
    }
	
	
	protected static $defaultCategories = [
		'income' => [
			'Заработная плата',
			'Социальнык выплаты',
			'Доход от бизнеса',
			'Призы, выигрыши',
			'Пенсия',
			'Дивиденды',
			'Прочее'
		],
		'outcome' => [
			'Авто',
			'Продукты',
			'Образование',
			'Отдых и развлечение',
			'Подарки',
			'Хобби',
			'Сбережения',
			'Квартира и связь',
			'Товары для дома',
			'Одежда и аксессуары',
			'Красота и здоровье',
			'Транспорт',
			'Долги',
			'Дети',
			'Прочее',
			'Домашние животные',
			'Страхование',
			'Налоги'
		]
	];
	
	
	public function getDefaultCategories(){
				
		return $this->defaultCategories;
	}
	
	public static function getCategiories(){
		$cat = Category::where('user_id','=',Auth::user()->id)->get();
		
		if (count($cat) == 0) {
			
			self::loadDefaultCategories();
		}
	}
	
	
	public static function loadDefaultCategories(){
		
		$cat = Category::where('user_id','=',Auth::user()->id)->get();
		
		if (count($cat) != 0) {
			
			return;
		}
		
		
		foreach(self::$defaultCategories as $type => $cat) {
			foreach($cat as $c_name){
				$c = new Category();
				$c->user_id = Auth::user()->id;
				$c->name = $c_name;
				$c->type = $type;
				$c->save();
			}			
		}
		
		Auth::user()->default_settings = 1;
		Auth::user()->save();
	}

}
