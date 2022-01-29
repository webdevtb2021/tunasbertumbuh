<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
	public function getEmail()
	{
		return view('customauth.passwords.email');
	}

	public function postEmail(Request $request)
	{
		$data = $request->all();
		$validate = Validator::make($data,[
			'email' => 'required|email|exists:users',
		]);
		error_log("================  HERE ================");

		if($validate->fails()) {
			return response([
				"status" => "error",
				"message" => $validate->errors()->first()
			], 400);
		}

		$token = Str::random(64);

		DB::table('password_resets')->insert(
			['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
		);

		Mail::send('customauth.verify', ['token' => $token], function($message) use($request){
			$message->to($request->email);
			$message->subject('Reset Password Notification');
		});
		return response(['status' => 'success','message' => 'We have e-mailed your password reset link!'],200);
	}

	public function getEmailFromToken(Request $request) {
		$data = $request->all();
		
		// return response([
		// 	"status" => 'token',
		// 	"message" => $data["token"],
		// ],200);
	
		
		$validate = Validator::make($data, [
			"token" => 'required'
		]);

		if($validate->fails()) {
			return response([
				"status" => 'error',
				"message" => $validate->errors()->first(),
			],400);
		}

		$email = DB::table('password_resets')
						->where('token', '=', $data["token"])
						->select("email")
						->first();

		if($email == null) {
			return response([
				"status" => 'error',
				"message" => "email not found",
			],400);
		}

		return response([
			"status" => 'success',
			"message" => $email,
		],200);
	}
}