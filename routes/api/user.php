<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group( ['prefix' => 'user'],function(){
    
    Route::post('login',[App\Http\Controllers\API\User\LoginController::class,'login'])->name('userLogin'); 
    Route::post('signUp','LoginController@signup')->name('userSignup'); 
    Route::post('token/refresh','LoginController@refreshToken')->name('userRefreshToken');
    // Route::post('resend-mail', 'LoginController@sendEmailOtp');
    Route::post('send-otp', [App\Http\Controllers\API\User\LoginController::class,'sendOtp']);
    // Route::post('verify-email-otp', 'LoginController@verifyEmailOtp');
    Route::post('social-login', 'LoginController@socialLogin');
    
        Route::group( ['middleware' => ['auth:user'] ],function(){
            Route::post('updateprofile/detail', 'LoginController@update_profile');
            Route::post('updateprofile/Image', 'LoginController@update_profile_image');
            Route::get('getprofile', 'LoginController@get_profile');
            Route::get('get-all-specialities', 'SpecialityController@getAllSpeciality');
            Route::get('get-all-banners', 'BannerController@getAllbanner');
            
            Route::get('get-all-doctors', 'DoctorController@getAllDoctors');
            // Route::post('get-doctor-by-city_id', 'DoctorController@getDoctorsByLocation');
            Route::post('get-doctor-by-speciality_id', 'DoctorController@getDoctorsBySpecialityId');
            Route::post('get-doctor-by-SpecialitiesOrDoctor', 'DoctorController@getDoctorsBySpeciality');
            Route::post('get-doctor-detail', 'DoctorController@getDoctorDetail');

            Route::post('add-review', 'DoctorController@add_review');
            Route::get('get-favourite-doctors', 'DoctorController@getFavourite');

            Route::get('get-appointment', 'SlotController@getAppointment');

            Route::group( ['prefix' => 'slot'],function(){   
                Route::post('apply-coupon', 'SlotController@check_promocode'); 
                Route::post('create-order', 'SlotController@createOrder');
                Route::post('payment-complete', 'SlotController@PaymentComplete');
            });  
    }); 
});



