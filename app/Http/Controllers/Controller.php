<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
	
	public function __construct(){
        $this->middleware('auth');
		$this->middleware('defaultsettings');
    }
	
    use DispatchesJobs, ValidatesRequests;
}
