<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DivisionController;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\PartnershipController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MerchandiseController;
use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\FundreportController;
use App\Http\Controllers\API\VolunteerController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\API\SesipbController;
use App\Http\Controllers\API\PesertapbController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// setiap kali akses API ini, harus menyertakan Authorization Bearer Tokennya di HTTP REQUEST nya
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::apiResource('/donations', DonationController::class); 
    Route::apiResource('/adminfinance',FundreportController::class);
    Route::apiResource('/adminvolunteer',VolunteerController::class);
    Route::apiResource('/admindivision',DivisionController::class);
    Route::apiResource('/adminmember',UserController::class);
    Route::apiResource('/adminmember/{userid}/adminposition', PositionController::class); 
    Route::apiResource('/adminpartnership',PartnershipController::class);
    Route::apiResource('/adminmerchandise', MerchandiseController::class); 
    Route::apiResource('/admindonation', DonationController::class); 
    Route::apiResource('/adminarticle', ArticleController::class); 
    Route::apiResource('/adminproject', ProjectController::class); 
    Route::apiResource('/adminsesipb',SesipbController::class);
    Route::apiResource('/adminpesertapb',PesertapbController::class);
    Route::get('/adminpesertapbs/{id}',[PesertapbController::class, 'indexFilter']);
    Route::get('/profile/{userid}',[UserController::class,'show']); 
    Route::put('/profile/{userid}',[UserController::class, 'update']);
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::get('/homepage', [App\Http\Controllers\API\HomepageController::class, 'index']);
// Route::get('/forget-password', [ForgotPasswordController::class, 'getEmail']);
Route::post('/forget-password', [ForgotPasswordController::class, 'postEmail']);
Route::post('/getEmail', [ForgotPasswordController::class, 'getEmailFromToken']);
Route::put('/resetPassword',[ResetPasswordController::class, 'updatePassword']);
// Route::get('/reset-password/{token}',[ResetPasswordController::class, 'getPassword']);
Route::get('/partnerships', [PartnershipController::class, 'index']);
Route::get('/volunteers', [VolunteerController::class, 'indexVolunteer']); 
Route::get('/projects', [ProjectController::class,'indexProjects']); 
Route::get('/projects/{id}', [ProjectController::class,'show']); 
Route::get('/testimonies', [UserController::class,'indexTestimonies']); 
Route::get('/members', [UserController::class,'indexMembers']); 
Route::get('/members/{period}', [UserController::class,'indexMembers']); 
Route::get('/finance', [FundreportController::class,'indexFinance']); 
Route::get('/articles', [ArticleController::class,'indexArticles']); 
Route::get('/articles/{id}', [ArticleController::class,'show']); 
Route::get('merchandises', [MerchandiseController::class,'indexMerchandise']); 
Route::get('/donationGuest', [DonationController::class,'indexDonations']); 

Route::get('/pekanbeasiswa',[SesipbController::class, 'index']);
Route::post('/pekanbeasiswa',[PesertapbController::class, 'store']);
Route::put('/absensipekanbeasiswa',[PesertapbController::class, 'update']);