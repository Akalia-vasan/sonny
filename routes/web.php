<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Doctor\Auth\LoginController@showLoginForm')->name('login');
// Route::get('/','HomeController@index');

// Route::get('/search','HomeController@index');
// Route::get('/blog','HomeController@blog');
// Route::get('/blog/detail/{id}','HomeController@blogdetail')->name('blogdetail');
// Route::post('/search','HomeController@search')->name('search');
// Route::post('/search-bed','HomeController@search_bed')->name('search_bed');
// Route::post('/search1','HomeController@search1')->name('search1');


// Route::post('/fetch', 'HomeController@fetch')->name('fetchCity');

// Route::get('/fetch', 'HomeController@fetch')->name('fetchCity');
// Route::post('/blog/comment', 'HomeController@blogComment')->name('post.comment');
// Route::post('/getcity','PatientController@getcity')->name('getcity1');
// Route::get('/doctor-profile/{id}','HomeController@profile');
// Route::get('/book/{id}','HomeController@book');
// Route::get('available/bed','HomeController@avaibleBed')->name('available_bed');
// Route::get('available/bed-detail/{id?}','HomeController@avaibleBedDetails')->name('bed_details');


// Route::get('available/nurse-detail','HomeController@nurseDetails')->name('nurseDetails');

// Route::get('/book_nurse','HomeController@book_nurse')->name('book_nurse');
// Route::post('/save_nurse_booking','HomeController@save_nurse_booking')->name('save_nurse_booking');


// Route::get('register','Auth\RegisterController@preregisterview')->name('preregisterview');
// Route::post('pre/register','Auth\RegisterController@preregister')->name('preregister');
// Route::get('password_reset/{token}', 'HomeController@password_reset_view');
// Route::post('change/password/{token}', 'HomeController@updatepassword')->name('change.password');
// Route::get('login','Auth\LoginController@preloginview')->name('loginview');
// Route::post('login/otp','Auth\LoginController@prelogin')->name('prelogin');

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login1', 'Auth\LoginController@login1')->name('login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register1', 'Auth\RegisterController@create')->name('register');

// Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
// Auth::routes();
Route::name('patient.')->namespace('Patient')->middleware(['auth:web'])->group(function() 
{
    // Route::get('/home','HomeController@index')->name('home');
    // Route::post('/getcity','PatientController@getcity')->name('getcity');
    // Route::post('/applyCoupon','PatientController@applyCoupon')->name('applyCoupon');
    // Route::post('/add-review','PatientController@add_review')->name('add_review'); 
    // Route::get('/favourite-doctor','PatientController@favourite')->name('favourite'); 
    // Route::get('/bed-bookind-order','PatientController@bedbookingorder')->name('bed.booking.order');
    // Route::group(['prefix' => 'profile'], function() {

    //     Route::get('/change-profile-setting','PatientController@changeprofile')->name('change_profile');
    //     Route::post('/update-profile-setting','PatientController@updateprofile')->name('update_profile');

    //     Route::get('/change-password','PatientController@changepassword')->name('change_password');
    //     Route::post('/update-password','PatientController@updatechangepassword')->name('update_password');
    // });

    // Route::group(['prefix' => 'account'], function() {

    //     Route::get('/','AccountController@index')->name('account');
    //     Route::post('/update','AccountController@store')->name('account.update');
    //     Route::post('/payout_request','AccountController@payout')->name('account.payout_request');

    // });
    // Route::resource('medical_detail', MedicalDetailController::class);
    // Route::post('/medical_detail/getData','MedicalDetailController@getData')->name('getData');
    // Route::resource('medical_record', MedicalRecordController::class);
    // Route::get('/prescription-detail/{id}','HomeController@prescriptionDetail')->name('prescription.detail');

    // Route::group(['prefix' => 'pay'], function() {

    //     Route::post('/checkout','PaymentController@prepaymentdata1')->name('checkout');
    //     Route::post('/confirm','PaymentController@prepaymentdata')->name('prepayment');
    //     Route::post('/order','PaymentController@initiatepayment')->name('initiate.payment');
    //     Route::post('/complete','PaymentController@payment_complete')->name('complete.payment');
    //     Route::post('/failed','PaymentController@paymentfailed')->name('paymentfailed');

    //     Route::get('/bed/{id}/checkout','PaymentController@prepaymentdataforbed1')->name('bed.checkout');
    //     Route::post('/bed/confirm','PaymentController@prepaymentdataforbed')->name('prepaymentdataforbed');
    //     Route::post('/bed/order','PaymentController@initiatepaymentforbed')->name('initiate.payment.bed');
    //     Route::post('/bed/complete','PaymentController@payment_complete_for_bed')->name('complete.payment.bed');
    // });
    
    
});