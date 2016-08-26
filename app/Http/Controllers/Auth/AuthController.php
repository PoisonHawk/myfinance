<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth; 
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    public $redirectPath = '/';
    public $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {		
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
			'status' => 0,
			'token' => str_random(),
        ]);
    }
	
	public function postRegister(Request $request)
    {
		
        $validator = $this->validator($request->all());

//        if ($validator->fails()) {
//            $this->throwValidationException(
//                $request, $validator
//            );
//        }

//        $this->create($request->all());
						
		
		$token = str_random();
		
		$message ='Вы получили это письмо, так как регистрировались на сайте myfinance.com. ';
		$message ='Для завершения регистрации перейдите по ссылке http://'. $_SERVER['HTTP_HOST'].'/auth/confirmregister/'.$token .' . ';	
		$message .= 'Если Вы не регистрировались на сайте, проигнорируйте это письмо!';
		
		try{
			mail($request->input('mail'), 'Confirm Registration', $message);
		} catch (Exception $e){
			return redirect()->back()->withErrors(['Извините. Произошла ошибка. Попробуйте позже']);
		}
		//todo mail
//		 Mail::send('emails.confirm', ['token' => $token], function ($m) use ($request){
//            $m->from('hello@app.com');
//            $m->to('savochkin2010@yandex.ru');		
//			$m->subject('Confirm Registration');
//        });		
		
		return view('auth.confirmregister', ['email'=> $request->input('email')]);
      
    }
	
	
	public function confirmRegister(Request $request){
		
		return view('auth.confirmregister', ['email'=> $request>input('email')]);
		
	}
		
	public function postConfirmRegister(Request $request){
		
	}
}
