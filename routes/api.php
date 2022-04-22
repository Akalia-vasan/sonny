<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:user-api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('setting/get/term_condition','SettingController@getTermCondition');
Route::get('setting/get/privacy_policy','SettingController@getPrivacyPolicy');
Route::get('setting/get/disclaimer','SettingController@getDisclaimer');
Route::get('setting/get/faq','SettingController@getFaq');
Route::post('enquiry/sent','SettingController@contact_store');
Route::post('password/reset','SettingController@password_reset');
