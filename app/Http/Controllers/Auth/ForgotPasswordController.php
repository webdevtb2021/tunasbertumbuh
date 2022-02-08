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

		// validasi inputan request
		$validate = Validator::make($data,[
			'email' => 'required|email|exists:users',
		]);

		// validasi gagal
		if($validate->fails()) {
			return response([
				"status" => "error",
				"message" => $validate->errors()->first()
			], 400);
		}

		// random token untuk membedakan request reset password satu dengan yang lain
		$token = Str::random(64);

		// disimpan ke dalam tabel password_resets
		DB::table('password_resets')->insert(
			['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
		);

		// Pengiriman email
		// Email dikirimkan menggunakan format yang sudah ditentukan dari file verify.blade.php
		// yang terletak pada folder customauth
		Mail::send('customauth.verify', ['token' => $token], function($message) use($request){
			$message->to($request->email);
			$message->subject('Reset Password Notification');
		});
		return response(['status' => 'success','message' => 'We have e-mailed your password reset link!'],200);
	}

	public function getEmailFromToken(Request $request) {

		// fungsi ini hanya digunakan untuk membantu verifikasi token yang sudah tidak terpakai
		// ketika pengguna sudah melakukan reset password, maka token akan dihapus dan email yang bersangkutan tidak akan ada di dalam database
		// maka dari itu, jika hal tersebut terjadi, maka tidak sembarang pengguna dapat mengakses halaman resetPassword.vue

		$data = $request->all();

		$validate = Validator::make($data, [
			"token" => 'required'
		]);

		if($validate->fails()) {
			return response([
				"status" => 'error',
				"message" => $validate->errors()->first(),
			],400);
		}

		// ambil email berdasarkan token yang diberikan, ambil hasil yang paling atas karena semua token beda2
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