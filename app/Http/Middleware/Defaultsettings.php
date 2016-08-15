<?php

namespace App\Http\Middleware;

use Closure;
use App\Category;
use App\User;

class Defaultsettings
{
	
	 /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(User $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		
		if ($this->auth->default_settings == 0) {
			Category::loadDefaultCategories();
		}
		
        return $next($request);
    }
}
