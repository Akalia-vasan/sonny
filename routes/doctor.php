<?php

use Illuminate\Support\Facades\Route; 

Route::name('doctor.')->prefix('doctor')->namespace('Auth')->middleware('guest:doctor')->group(function() {

    // Authentication Routes...
    Route::get('/', 'LoginController@showLoginForm')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.submit');

    // Registration Routes...
    // Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'RegisterController@register')->name('register.submit');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset.submit');
});

Route::name('doctor.')->prefix('doctor')->middleware(['auth:doctor'])->group(function() 
{

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/getcity','HomeController@getcity')->name('getcity');
    Route::post('/update-slot','ScheduleController@update_slot')->name('update_slot');
    Route::group(['prefix' => 'profile'], function() {
        
        Route::get('/change-profile-setting','HomeController@changeprofile')->name('change_profile');
        Route::post('/update-profile-setting','HomeController@updateprofile')->name('update_profile');

        Route::get('/change-social-link','HomeController@changeSocialLink')->name('change_social_link');
        Route::post('/update-social-link','HomeController@updateSocialLink')->name('update_social_link');
        
        Route::get('/schedule-timing','ScheduleController@create')->name('schedule-timing');
        Route::post('/schedule-timing','ScheduleController@store')->name('schedule-timing');
        Route::post('/update-schedule-timing','ScheduleController@update')->name('update-schedule-timing');
        // Route::post('/update-social-link','HomeController@updateSocialLink')->name('update_social_link');

        Route::get('/slot-timing','ScheduleController@slots')->name('slot-timing');
        Route::post('/filter-slot-timing','ScheduleController@filterslots')->name('filter-slot-timing');
        Route::post('/slot-timing/create','ScheduleController@createSlot')->name('slot-timing-create');

        Route::get('/view-review','HomeController@viewReview')->name('view-review');

        Route::get('/change-password','HomeController@changedoctorpassword')->name('change_password');
        Route::post('/update-password','HomeController@updatedoctorchangepassword')->name('update_password');
    
    });

    Route::group(['prefix' => 'account'], function() {

        Route::get('/','AccountController@index')->name('account');
        Route::post('/update','AccountController@store')->name('account.update');
        Route::post('/payout_request','AccountController@payout')->name('account.payout_request');

    });

    Route::group(['prefix' => 'patient'], function() {

        Route::get('/','PatientController@index')->name('patient');
        Route::get('/profile/{id}','HomeController@patientdetail')->name('patient.profiledetail');
        Route::get('/add-prescription/{id}','HomeController@addpatintPrescription')->name('patient.prescription');
        Route::get('/show-prescription/{id}','HomeController@showpatintPrescription')->name('patient.prescription.show');
        Route::post('/store-prescription','HomeController@storepatintPrescription')->name('store.prescription');
        Route::get('/edit-prescription/{id}','HomeController@editpatintPrescription')->name('edit.prescription');
        Route::post('/update-prescription','HomeController@updatepatintPrescription')->name('update.prescription');
        Route::post('/store-medical-record','HomeController@saveMedicalRecord')->name('store.medical.record');
        
        Route::get('/add-billing/{id}','HomeController@addpatintBilling')->name('patient.billing');
         
    });
    Route::group(['prefix' => 'blogs'], function() {
        Route::get('/list','BlogController@index')->name('blog.index');
        Route::get('/create','BlogController@create')->name('blog.create');
        Route::post('/store','BlogController@store')->name('blog.store');
        Route::get('/edit/{id}','BlogController@edit')->name('blog.edit');
        Route::get('/show/{id}','BlogController@show')->name('blog.show');
        Route::put('/update/{id}','BlogController@update')->name('blog.update');
    });
    Route::group(['prefix' => 'appointment'], function() {
        Route::get('/', 'HomeController@appointment')->name('appointment');
        Route::get('/{id}/accept', 'HomeController@appointmentAccept')->name('appointment.accept');
        Route::get('/{id}/cancel', 'HomeController@appointmentCancel')->name('appointment.cancel');
        Route::get('/{id}/cancelAccepted', 'HomeController@acceptedAppointmentCancel')->name('appointment.cancelAccepted');
        
    });
});