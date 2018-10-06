<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Employee;
use App\Role;
use Validator;
use Eloquent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Mail;
use Auth;
use Illuminate\Http\Request;


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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/section';
	//protected $redirectAfterLogout = '/user/logout_verify';
   	
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
		
		$this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
		//\Session::set('backUrl', URL::previous());
    }
    
    public function showRegistrationForm()
    {
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
        $roleCount = Role::count();
		if($roleCount != 0) {
			$userCount = User::count();
			//if($userCount == 0) {
			return view('auth.register',compact('help_group_pages','resource_group_pages','corporate_group_pages'));
			/* } else {
				return redirect('user/login');
			} */
		} else {
			return view('errors.error', [
				'title' => 'Migration not completed',
				'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
			]);
		}
    }
    
    public function showLoginForm()
    {
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/* $roleCount = Role::count();
		if($roleCount != 0) {
			$userCount = User::count();
			if($userCount == 0) {
				return redirect('register');
			} else {
				return view('auth.login',compact('help_group_pages','resource_group_pages','corporate_group_pages'));
			}
		} else {
			return view('errors.error', [
				'title' => 'Migration not completed',
				'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
			]);
		} */
		
		$view = property_exists($this, 'loginView') ? $this->loginView : 'auth.authenticate';
		if (view()->exists($view)) {
			return view($view);
		}
		/**
		 * save the previous page in the session
		 */
		/* $previous_url = Session::get('_previous.url');
		$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$ref = rtrim($ref, '/');
		if($previous_url != url('login')){
			Session::put('referrer', $ref);
			if($previous_url == $ref){
				Session::put('url.intended', $ref);
			}
		}  */
		/**
		 * save the previous page in the session end
		 */
		Session::put('url.intended', '/user/section');
		return view('auth.login',compact('help_group_pages','resource_group_pages','corporate_group_pages'));
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
            'password' => 'required|min:6|confirmed',
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
		// TODO: This is Not Standard. Need to find alternative
        Eloquent::unguard();
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'context_id' => 0,
            'type' => "User",
			'verify' => 0,
        ]);
		$data['activate_link'] = url('user/account_activate/'.base64_encode($data['email']));
		$role = Role::where('name', 'User')->first();
        $user->attachRole($role);		
		Mail::send('emails.welcome', ['data' => $data], function ($m) use ($data){			
			$m->to($data['email'], $data['name'])				
				->subject('Welcome: Printed Cart');		
		});		
		//return redirect()->back()->with(['success'=>'Thanks for signing up! Please check your email.']);
		//return redirect()->back()->with(['success'=>'Thanks for signing up! Please check your email.']);		
		return $user;
    }
	
	public function account_verify($email = null){
		$email = base64_decode($email);
		$verify = User::where('email','=',$email)->update(array('verify'=>1));
		if($verify){
			return redirect('/user/login')->with(['success'=>'Your Account verified successfully!']);
		}else{
			return redirect('/user/login')->withErrors(['error'=>'Something went wrong! Account not verified yet.']);
		}
	}
	
	/* public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/user/logout_verify');
    } */
	
	/* public function logout(Request $request) {
		Auth::logout();
		return redirect('/user/logout_verify');
	} */
}
