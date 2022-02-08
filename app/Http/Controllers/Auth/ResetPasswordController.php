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
        
        // validasi request HTML
        Validator::make($data, [
            "email" => "required|email|exist:users",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required",
        ]);

        // ambil data token yang ada di tabel password_resets
        $updatePassword = DB::table('password_resets')
                              ->where(['email' => $request->email])
                              ->where(['token' => $request->token])
                              ->first();

        // kalau nda ada, akan muncul error, invalid token yang berarti token tersebut paling ndak sudah terhapus dari proses penggantian password yang sebelumnya
        if(!$updatePassword) {
            return response(['error' => 'Invalid Token'], 404);
        }
        
        // kalau semua validasi sudah benar, tinggal diganti aja password yang ada pada table User
        $user = User::where(['email' => $request->email])
                    ->update(['password' => bcrypt($request->password)]);
        
        //  jangan lupa untuk hapus semua token yang berkaitan dengan email yang bersangkutan
        // biar kalau ngirim permintaan reset password lebih dari 1, nanti kehapus semua dan ndak bisa akses 
        // halaman resetPassword.vue
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        
        // return responsenya
        return response(['status' => 'success', "message" => "Berhasil mengganti password"]);
    }
}
