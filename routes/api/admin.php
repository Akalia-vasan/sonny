<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group( ['prefix' => 'admin'],function(){

    Route::get('/home', 'HomeController@index')->name('admin.api.home');
    Route::get('/appointment', 'HomeController@appointment')->name('admin.api.appointment.index');
    Route::get('/appointment/{id}/accept', 'HomeController@appointmentAccept')->name('admin.api.appointment.accept');
    Route::get('/appointment/{id}/cancel', 'HomeController@appointmentCancel')->name('admin.api.appointment.cancel');
    Route::get('/appointment/{id}/cancelAccepted', 'HomeController@appointmentCancelAccepted')->name('admin.api.appointment.cancelAccepted');
 
    Route::get('/nurse_booking', 'HomeController@nurse_booking')->name('admin.api.nurse_booking');
    Route::get('/update_nurse_booking_status', 'HomeController@update_nurse_booking_status')->name('admin.api.update_nurse_booking_status');
    Route::get('/delete_nurse_booking_order/{id}', 'HomeController@delete_nurse_booking_order')->name('admin.api.delete_nurse_booking_order');
    Route::group( ['prefix' => 'area'],function(){
        Route::get('/','AreaController@index')->name('admin.api.area.index'); 
        Route::get('/create','AreaController@create')->name('admin.api.area.create');
        Route::post('/create','AreaController@store')->name('admin.api.area.store'); 
        Route::get('/edit/{id}','AreaController@edit')->name('admin.api.area.edit');
        Route::post('/edit/{id}','AreaController@update')->name('admin.api.area.update');
        Route::get('/delete/{id}', 'AreaController@destroy')->name('admin.api.area.delete');
    });

    Route::group( ['prefix' => 'banner'],function(){
        Route::get('/','BannerController@index')->name('admin.api.banner.index'); 
        Route::get('/create','BannerController@create')->name('admin.api.banner.create');
        Route::post('/create','BannerController@store')->name('admin.api.banner.store'); 
        Route::get('/edit/{id}','BannerController@edit')->name('admin.api.banner.edit');
        Route::post('/edit/{id}','BannerController@update')->name('admin.api.banner.update');
        Route::get('/delete/{id}', 'BannerController@destroy')->name('admin.api.banner.delete');
    });

    Route::group( ['prefix' => 'bed-type'],function(){
        Route::get('/','BedTypeController@index')->name('admin.api.bed-type.index'); 
        Route::get('/create','BedTypeController@create')->name('admin.api.bed-type.create');
        Route::post('/create','BedTypeController@store')->name('admin.api.bed-type.store'); 
        Route::get('/edit/{id}','BedTypeController@edit')->name('admin.api.bed-type.edit');
        Route::post('/edit/{id}','BedTypeController@update')->name('admin.api.bed-type.update');
        Route::get('/delete/{id}', 'BedTypeController@destroy')->name('admin.api.bed-type.delete');
    });

    Route::group( ['prefix' => 'bed'],function(){
        Route::get('/','BedController@index')->name('admin.api.bed.index'); 
        Route::get('/create','BedController@create')->name('admin.api.bed.create');
        Route::post('/create','BedController@store')->name('admin.api.bed.store'); 
        Route::get('/edit/{id}','BedController@edit')->name('admin.api.bed.edit');
        Route::post('/edit/{id}','BedController@update')->name('admin.api.bed.update');
        Route::get('/delete/{id}', 'BedController@destroy')->name('admin.api.bed.delete');
    });

    Route::group( ['prefix' => 'blogCategory'],function(){
        Route::get('/','BlogCategoryController@index')->name('admin.api.blog-category.index'); 
        Route::get('/create','BlogCategoryController@create')->name('admin.api.blog-category.create');
        Route::post('/create','BlogCategoryController@store')->name('admin.api.blog-category.store'); 
        Route::get('/edit/{id}','BlogCategoryController@edit')->name('admin.api.blog-category.edit');
        Route::post('/edit/{id}','BlogCategoryController@update')->name('admin.api.blog-category.update');
        Route::get('/delete/{id}', 'BlogCategoryController@destroy')->name('admin.api.blog-category.delete');
    });

    Route::group( ['prefix' => 'blog'],function(){
        Route::get('/','BlogController@index')->name('admin.api.blog.index'); 
        Route::get('/create','BlogController@create')->name('admin.api.blog.create');
        Route::post('/create','BlogController@store')->name('admin.api.blog.store'); 
        Route::get('/edit/{id}','BlogController@edit')->name('admin.api.blog.edit');
        Route::post('/edit/{id}','BlogController@update')->name('admin.api.blog.update');
        Route::get('/delete/{id}', 'BlogController@destroy')->name('admin.api.blog.delete');
        Route::get('/pending','BlogController@pending')->name('admin.api.blog.pending');
        Route::get('/blog-comment','BlogController@blogComment')->name('admin.api.blog.blog-comment');
    });

    Route::group( ['prefix' => 'center'],function(){
        Route::get('/','CenterController@index')->name('admin.api.center.index'); 
        Route::get('/create','CenterController@create')->name('admin.api.center.create');
        Route::post('/create','CenterController@store')->name('admin.api.center.store'); 
        Route::get('/edit/{id}','CenterController@edit')->name('admin.api.center.edit');
        Route::post('/edit/{id}','CenterController@update')->name('admin.api.center.update');
        Route::get('/delete/{id}', 'CenterController@destroy')->name('admin.api.center.delete');
        Route::get('/get','CenterController@get')->name('admin.api.center.get');
    });

    Route::group( ['prefix' => 'content'],function(){
        Route::get('/','ContentController@app_index')->name('admin.api.content.index'); 
        Route::get('/create','ContentController@addappcontent')->name('admin.api.content.create');
        Route::post('/create','ContentController@app_store')->name('admin.api.content.store'); 
        Route::get('/edit/{id}','ContentController@app_content_edit')->name('admin.api.content.edit');
        Route::post('/edit/{id}','ContentController@app_update')->name('admin.api.content.update');
        Route::get('/delete/{id}', 'ContentController@appcontentdelete')->name('admin.api.content.delete');
    });

    Route::group( ['prefix' => 'coupon'],function(){
        Route::get('/','CouponController@index')->name('admin.api.coupon.index'); 
        Route::get('/create','CouponController@create')->name('admin.api.coupon.create');
        Route::post('/create','CouponController@store')->name('admin.api.coupon.store'); 
        Route::get('/edit/{id}','CouponController@edit')->name('admin.api.coupon.edit');
        Route::post('/edit/{id}','CouponController@update')->name('admin.api.coupon.update');
        Route::get('/delete/{id}', 'CouponController@destroy')->name('admin.api.coupon.delete');
    });

    Route::group(['prefix' => 'doctor'], function() {
                
        Route::get('/', 'DoctorController@index')->name('admin.api.doctor.index');
        Route::post('/getcity','DoctorController@getcity')->name('admin.api.doctor.getcity');
        Route::post('/getentity','DoctorController@getentity')->name('admin.api.doctor.getentity');
        Route::get('/add', 'DoctorController@addDoctor')->name('admin.api.doctor.create');
        Route::post('/store', 'DoctorController@storeDoctor')->name('admin.api.doctor.store');
        Route::get('/edit/{id}', 'DoctorController@editDoctor')->name('admin.api.doctor.edit');
        Route::get('/show/{id}', 'DoctorController@showDoctor')->name('admin.api.doctor.show');
        Route::post('/update/{id}', 'DoctorController@updateDoctor')->name('admin.api.doctor.update');
        Route::get('/delete/{id}', 'DoctorController@deleteDoctor')->name('admin.api.doctor.delete');
        Route::get('/delete/image/{id?}/{name?}', 'DoctorController@deleteclinicImage')->name('admin.api.doctor.clinicimage.delete');
    });

    Route::group(['prefix' => 'enquiry'], function() {
        Route::get('/', 'EnquiryController@index')->name('admin.api.enquiry.index');
        Route::get('/{id}', 'EnquiryController@enq_delete')->name('admin.api.enquiry.delete');
        Route::get('/view/{id}', 'EnquiryController@enq_view')->name('admin.api.enquiry.view');
        Route::post('/reply','EnquiryController@enquiry_reply')->name('admin.api.enquiry.reply');
    });

    Route::group( ['prefix' => 'faq-category'],function(){
        Route::get('/','FAQCategoryController@index')->name('admin.api.faq-category.index'); 
        Route::get('/create','FAQCategoryController@create')->name('admin.api.faq-category.create');
        Route::post('/create','FAQCategoryController@store')->name('admin.api.faq-category.store'); 
        Route::get('/edit/{id}','FAQCategoryController@edit')->name('admin.api.faq-category.edit');
        Route::post('/edit/{id}','FAQCategoryController@update')->name('admin.api.faq-category.update');
        Route::get('/delete/{id}', 'FAQCategoryController@destroy')->name('admin.api.faq-category.delete');
    });

    Route::group( ['prefix' => 'faq'],function(){
        Route::get('/','FAQController@index')->name('admin.api.faq.index'); 
        Route::get('/create','FAQController@create')->name('admin.api.faq.create');
        Route::post('/create','FAQController@store')->name('admin.api.faq.store'); 
        Route::get('/edit/{id}','FAQController@edit')->name('admin.api.faq.edit');
        Route::post('/edit/{id}','FAQController@update')->name('admin.api.faq.update');
        Route::get('/delete/{id}', 'FAQController@destroy')->name('admin.api.faq.delete');
    });

    Route::resource('hospital', HospitalController::class);
    Route::resource('product/category', ProductCategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::group(['prefix' => 'lab-test'], function() {
        Route::get('/', 'LabTestController@index')->name('admin.api.lab-test.index');
        Route::get('/create', 'LabTestController@create')->name('admin.api.lab-test.create');
        Route::get('/edit/{id}', 'LabTestController@edit')->name('admin.api.lab-test.edit');
        Route::post('/store', 'LabTestController@store')->name('admin.api.lab-test.store');
        Route::post('/update/{id}', 'LabTestController@update')->name('admin.api.lab-test.update');
        Route::get('/delete/{id}', 'LabTestController@destroy')->name('admin.api.lab-test.delete');
    });

    Route::group(['prefix' => 'service'], function() {
        Route::get('/', 'ServiceController@index')->name('admin.api.service.index');
        Route::get('/create', 'ServiceController@create')->name('admin.api.service.create');
        Route::get('/edit/{id}', 'ServiceController@edit')->name('admin.api.service.edit');
        Route::post('/store', 'ServiceController@store')->name('admin.api.service.store');
        Route::post('/update/{id}', 'ServiceController@update')->name('admin.api.service.update');
        Route::get('/delete/{id}', 'ServiceController@destroy')->name('admin.api.service.delete');
    });

    Route::group(['prefix' => 'setting'], function() {

        Route::get('/', 'SettingController@index')->name('admin.api.setting.index');
        Route::get('/profile', 'SettingController@profile_index')->name('admin.api.setting.profile');
        Route::post('/appname', 'SettingController@updateappname')->name('admin.api.setting.appname');
        Route::post('/logo', 'SettingController@updatelogo')->name('admin.api.setting.logo');
        Route::post('/copyright', 'SettingController@updatecopyright')->name('admin.api.setting.copyright');
        // Route::post('/email', 'SettingController@updateadminemail')->name('admin.api.setting.email');
        // Route::post('/password', 'SettingController@updateadminpassword')->name('admin.api.setting.password');

        Route::post('/app_address', 'SettingController@updatecompanyaddress')->name('admin.api.setting.app_address');
        Route::post('/app_email', 'SettingController@updatecompanyemail')->name('admin.api.setting.app_email');
        Route::post('/app_mobile', 'SettingController@updatecompanymobile')->name('admin.api.setting.app_mobile');
        Route::post('/app_version', 'SettingController@updateappversion')->name('admin.api.setting.app_version');
    });

    Route::group(['prefix' => 'speciality'], function() {
        Route::get('/', 'SpecialityController@index')->name('admin.api.speciality.index');
        Route::get('/create', 'SpecialityController@create')->name('admin.api.speciality.create');
        Route::get('/edit/{id}', 'SpecialityController@edit')->name('admin.api.speciality.edit');
        Route::post('/store', 'SpecialityController@store')->name('admin.api.speciality.store');
        Route::post('/update/{id}', 'SpecialityController@update')->name('admin.api.speciality.update');
        Route::get('/delete/{id}', 'SpecialityController@destroy')->name('admin.api.speciality.delete');
    });

});
 