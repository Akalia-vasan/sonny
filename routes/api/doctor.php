<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group( ['prefix' => 'doctor'],function(){

    Route::post('login','LoginController@login')->name('doctorLogin'); 
    // Route::post('signUp','LoginController@signup')->name('doctorSignup'); 
    Route::post('refreshToken','LoginController@refreshToken')->name('doctorRefreshToken');

    Route::group( ['middleware' => [] ],function(){
        Route::get('getprofile', 'LoginController@get_profile');
        Route::post('updateprofile/Image', 'LoginController@update_profile_image');

        Route::group( ['prefix' => 'schedule'],function(){
            Route::get('/','ScheduleController@create2')->name('doctor.api.schedule.create-uu'); 
            Route::get('/create','ScheduleController@create')->name('doctor.api.schedule.create');
            Route::post('/create','ScheduleController@store')->name('doctor.api.schedule.store'); 
            Route::post('/edit/{id}','ScheduleController@update')->name('doctor.api.schedule.update');
            Route::get('/slots', 'ScheduleController@slots')->name('doctor.api.schedule.slots');
            Route::post('/filter-slots','ScheduleController@filterslots')->name('doctor.api.schedule.filter-slots');
            Route::post('/create-slot','ScheduleController@createSlot')->name('doctor.api.schedule.create-slot');
            Route::post('/update-slot','ScheduleController@update_slot')->name('doctor.api.schedule.update-slot');
        });

        Route::group( ['prefix' => 'blog'],function(){
            Route::get('/','BlogController@index')->name('doctor.api.blog.index'); 
            Route::get('/create','BlogController@create')->name('doctor.api.blog.create');
            Route::post('/create','BlogController@store')->name('doctor.api.blog.store'); 
            Route::get('/edit/{id}','BlogController@edit')->name('doctor.api.blog.edit');
            Route::post('/edit/{id}','BlogController@update')->name('doctor.api.blog.update');
        });

        Route::group( ['prefix' => 'patient'],function(){
            Route::get('/get-all-patient','PatientController@index')->name('doctor.api.patient.index');
        });

        Route::group(['prefix' => 'profile'], function() {
            Route::get('/home', 'HomeController@index')->name('doctor.api.profile.home');
            Route::post('/getcity','HomeController@getcity')->name('doctor.api.profile.getcity');
            Route::get('/change-profile-setting','HomeController@changeprofile')->name('doctor.api.profile.change_profile');
            Route::post('/update-profile-setting','HomeController@updateprofile')->name('doctor.api.profile.update_profile');
    
            Route::get('/change-social-link','HomeController@changeSocialLink')->name('doctor.api.profile.change_social_link');
            Route::post('/update-social-link','HomeController@updateSocialLink')->name('doctor.api.profile.update_social_link');
            Route::get('/view-review','HomeController@viewReview')->name('doctor.api.profile.view-review');

            Route::get('/change-password','HomeController@changedoctorpassword')->name('doctor.api.profile.change_password');
            Route::post('/update-password','HomeController@updatedoctorchangepassword')->name('doctor.api.profile.update_password');
            
        });

        Route::group(['prefix' => 'appointment'], function() {
            Route::get('/', 'HomeController@appointment')->name('doctor.api.appointment');
            Route::get('/{id}/accept', 'HomeController@appointmentAccept')->name('doctor.api.appointment.accept');
            Route::get('/{id}/cancel', 'HomeController@appointmentCancel')->name('doctor.api.appointment.cancel');
            Route::get('/{id}/cancel-accepted', 'HomeController@acceptedAppointmentCancel')->name('doctor.api.appointment.cancelAccepted');
            
        });

        Route::group(['prefix' => 'patient'], function() {
            Route::get('/profile/{id}','HomeController@patientdetail')->name('doctor.api.patient.profiledetail');
            Route::get('/add-prescription/{id}','HomeController@addpatintPrescription')->name('doctor.api.patient.prescription');
            Route::get('/show-prescription/{id}','HomeController@showpatintPrescription')->name('doctor.api.patient.prescription.show');
            Route::post('/store-prescription','HomeController@storepatintPrescription')->name('doctor.api.store.prescription');
            Route::get('/edit-prescription/{id}','HomeController@editpatintPrescription')->name('doctor.api.edit.prescription');
            Route::post('/update-prescription','HomeController@updatepatintPrescription')->name('doctor.api.update.prescription');
            Route::post('/store-medical-record','HomeController@saveMedicalRecord')->name('doctor.api.store.medical.record');
            
            Route::get('/add-billing/{id}','HomeController@addpatintBilling')->name('doctor.api.patient.billing');
             
        });

        Route::group(['prefix' => 'account'], function() {

            Route::get('/','AccountController@index')->name('doctor.api.account.index');
            Route::post('/update','AccountController@store')->name('doctor.api.account.update');
            Route::post('/payout_request','AccountController@payout')->name('doctor.api.account.payout_request');
    
        });
    });
});
 

