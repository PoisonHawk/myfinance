<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

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
			'Заработная плата' => [
				'Премии',
			],
			'Социальнык выплаты' => [
				'Пособия',
				'Алименты',
			],
			'Доход от бизнеса',
			'Призы, выигрыши',
			'Пенсия',
			'Дивиденды',
			'Прочее'
		],
		'outcome' => [
			'Авто' => [
				'Топливо',
				'Ремонт, ТО',
				'Стриаховка, налоги',
				'Штрафы',
			],
			'Продукты' => [
				'Бизнес ланч',
				'Продукты из супермаркета',
			],
			'Оразование' => [
				'Книги',
				'Учебники',
				'Курсы, тренинги',
				'Обучение',
				'Репетитор',
			],
			'Отдых и развлечение' => [
				'Кинотеатры',
				'Театры',
				'Выставки',
				'Спортивные мероприятия',
			],
			'Подарки',
			'Хобби',
			'Сбережения' => [
				'Депозит',
				'Инвестиции',
			],
			'Квартира и связь' => [
				'Коммунальные услуги',
				'Интернет и ТВ',
				'Сотовая связь',
				'Городской телефон',
			],
			'Товары для дома' => [
				'Ремонт',
				'Бытовая химия',
				'Бытовая техника',
				'Мебель посуда',
			],
			'Одежда и аксессуары' => [
				'Одежда',
				'Обувь',
				'Химчистка',
				'Ателье',
				'Ремонт обуви',
				'Аксессуары'
			],
			'Красота и здоровье' => [
				'Салоны красоты, парикмахерские',
				'Лекарства',
				'Мед. услуги',
				'Косметика, парфюмерия',
				'Фитнесс, йога',
			],
			'Транспорт' => [
				'Такси',
				'Общественный транспорт',
				'авиа, жд билеты',
			],
			'Долги' => [
				'Ипотека',
				'Кредит',
				'Аренда',
			],
			'Дети' => [
				'Одежда и обувь',
				'Питание',
				'Игрушки',
				'Хобби'
			],
			'Прочее',
			'Домашние животные',
			'Страхование',
			'Налоги'
		]
	];
		
	public static function loadDefaultCategories(){
		
		$cat = Category::where('user_id','=',Auth::user()->id)->get();
		
		if (count($cat) != 0) {			
			return;
		}
				
		DB::beginTransaction();
		
		try{
	
			foreach(self::$defaultCategories as $type => $categories) {
				
				foreach($categories as $root_category => $sub_category){
					
					$name  = is_array($sub_category) ? $root_category : $sub_category;
					
					$r_category = new Category();
					$r_category->user_id = Auth::user()->id;
					$r_category->name = $name;
					$r_category->type = $type;
					$r_category->save();
					
					if (is_array($sub_category)) {						
						
						foreach ($sub_category as $cat) {
							
							$category = new Category();
							$category->user_id = Auth::user()->id;
							$category->name = $cat;
							$category->type = $type;
							$category->save();
							
							$category->makeChildOf($r_category);
						}
					}
				}		

				Auth::user()->default_settings = 1;
				Auth::user()->save();
			}
		
		} catch (Exception $e) {
			
			//todo выкинуть сообщение об ошибке
			DB::rollback();
		}
		
		DB::commit();		
		
	}

}
