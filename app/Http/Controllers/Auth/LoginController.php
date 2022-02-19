<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    // 0: Have no access admin
    // 1: all access
    // 2: Web Dev
    // 3: HR
    // 4: Marketing and Fundraisin
    // 5: Comm and Partner
    // 6: Project management


    public function login(Request $request)
    {
        // ambil semua data request
        $loginData = $request->all();

        // validasi
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        // kalau gagal validasi
        if ($validate->fails()) {
            return response([
                "status" => "error",
                'message' => $validate->errors()->first()
            ], 400);
        }

        // kalau gagal login
        if (!Auth::attempt($loginData)) {
            return response([
                "status" => "error",
                'message' => 'Invalid Credentials', "data" => $loginData
            ], 401);
        }

        // cek status keaktifan user
        $user_status = User::select('status')->where('email', "=", $loginData["email"])->first();

        if ($user_status["status"] == 0) {
            return response([
                "status" => "error",
                'message' => 'Keanggotaan sudah tidak aktif', "data" => $user_status
            ], 401);
        }

        // ambil usernya
        $user = Auth::user();

        // token masuknya
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            "status" => "success",
            'message' => 'Selamat datang !',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $registerData = $request->all();
        $validate = Validator::make($registerData, [
            'firstName' => 'required|alpha',
            'lastName' => 'required|alpha',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()->first()], 400);
        }

        $registerData["name"] = $registerData["firstName"] . ' ' . $registerData["lastName"];
        $registerData["password"] = bcrypt($registerData["password"]);
        $registerData["status"] = 0; // status default tidak aktif
        $registerData["permission"] = 0; // default tidak memiliki akses sebagai admin

        $user = User::create($registerData);
        return response([
            'message' => 'Berhasil terdaftar !',
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        if ($logout) {
            return response([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ], 200);
        }

        return response([
            'status' => 'error',
            'message' => 'Logged out successful'
        ], 400);
    }
}
