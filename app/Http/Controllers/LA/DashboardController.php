<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Validator;
use Illuminate\Http\Request;
use DB;
use Mail;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(){
		$order_count = DB::table('orders')->count();//order count
		
		$project = DB::table('projects')->count();
		$pro_ord = number_format(($order_count/$project)*100,2);
		$bounce_rate = number_format(100-$pro_ord,2);//bounce rate 
		
		$user_count = DB::table('users')->where('type','User')->count();
		return view('la.dashboard',compact('order_count','bounce_rate','user_count'));
	}
	
	public function sendmail(Request $request){
		$rules = array(
			'email' => 'required|email',
			'subject' => 'required',
			'message' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
		if($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();
		}else{
			$post_data = $request->all();
			$data = array(
				'email' => $post_data['email'],
				'subject' => $post_data['subject'],
				'message' => $post_data['message']
			);
			Mail::send('emails.sendmail', $data, function($message)use($data){
				$message->from('alexjoby987@gmail.com','Administrator');
				$message->to($data['email']);
				$message->subject($data['subject']);
			});
			return redirect()->back()->with(['success'=>'Thanks, mail send successfully!']);
		}
	}
}