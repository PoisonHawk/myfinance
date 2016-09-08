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
			'token' => str_random(32),
        ]);
    }
	
	public function postRegister(Request $request)
    {
		
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
		
		try{	
			$user = $this->create($request->input());
		
			$message ='Вы получили это письмо, так как регистрировались на сайте myfinance.com. ';
			$message ='Для завершения регистрации перейдите по ссылке http://'. $_SERVER['HTTP_HOST'].'/auth/confirmregister?token='.$user->token .' . ';	
			$message .= 'Если Вы не регистрировались на сайте, проигнорируйте это письмо!';

		
			mail($request->input('email'), 'Confirm Registration', $message, 'From: MyFinance <info@myfinance.com> \r\n Content-type: text\plain');
		} catch (\Exception $e){
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
	
	
	public function getConfirmregister(Request $request){
			
		dd($request->input());
		
//		return view('auth.confirmregister', ['email'=> $request>input('email')]);
		
	}
		
	public function postConfirmRegister(Request $request){
		
	}
}
