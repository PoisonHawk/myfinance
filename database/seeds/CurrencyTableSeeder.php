<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->delete();

        DB::table('currency')
            
            ->insert([
            [
                'name'=>'rub',
                'iso4217'=>'RUB'
            ],
            [
                'name'=>'usd',
                'iso4217'=>'USD'
            ]
    ]);
    }
}
