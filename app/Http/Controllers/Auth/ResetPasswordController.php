<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function updatePassword(Request $request) {
        $data = $request->all();
     
        Validator::make($data, [
            "email" => "required|email|exist:users",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required",
        ]);

        $updatePassword = DB::table('password_resets')
                              ->where(['email' => $request->email])
                              ->where(['token' => $request->token])
                              ->first();

        if(!$updatePassword) {
            return response(['error' => 'Invalid Token'], 404);
        }

        $user = User::where(['email' => $request->email])
                    ->update(['password' => bcrypt($request->password)]);
        error_log($request->password);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        error_log("============ HWERHEREASJKDJASJKDNASJKDJKLASDKA =============");
        return response(['status' => 'success', "message" => "Berhasil mengganti password"]);
    }
}
