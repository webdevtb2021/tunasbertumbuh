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

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', [LoginController::class, 'logout']);
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);


Route::get('/homepage', [App\Http\Controllers\API\HomepageController::class, 'index']);
Route::apiResource('partnerships', PartnershipController::class);
Route::get('/volunteers', [VolunteerController::class, 'indexVolunteer']);
Route::apiResource('projects', ProjectController::class);
Route::get('/testimonies', [UserController::class, 'indexTestimonies']);
Route::get('/members', [UserController::class, 'indexMembers']);
Route::get('/members/{period}', [UserController::class, 'indexMembers']);
Route::get('/finance', [FundreportController::class, 'indexFinance']);
Route::apiResource('articles', ArticleController::class);
Route::apiResource('merchandises', MerchandiseController::class);
Route::get('/donationGuest', [DonationController::class, 'indexDonations']);
Route::apiResource('/donations', DonationController::class);
Route::apiResource('/adminfinance', FundreportController::class);
Route::apiResource('/adminvolunteer', VolunteerController::class);
Route::apiResource('/admindivision', DivisionController::class);

// Route::get('/forget-password', [ForgotPasswordController::class, 'getEmail']);
Route::post('/forget-password', [ForgotPasswordController::class, 'postEmail']);
Route::post('/getEmail', [ForgotPasswordController::class, 'getEmailFromToken']);

Route::put('/resetPassword',[ResetPasswordController::class, 'updatePassword']);
// Route::get('/reset-password/{token}',[ResetPasswordController::class, 'getPassword']);