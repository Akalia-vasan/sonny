<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->namespace('Auth')->middleware('guest:admin')->group(function() {

    // Authentication Routes...
    Route::get('/', 'LoginController@showLoginForm')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.submit');

});

Route::name('admin.')->prefix('admin')->middleware(['auth:admin'])->group(function() 
{
    Route::resource('roles', RoleController::class);
    Route::resource('subadmin', SubAdminController::class);
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/appointment', 'HomeController@appointment')->name('appointment.index');
    Route::get('/appointment/{id}/accept', 'HomeController@appointmentAccept')->name('appointment.accept');
    Route::get('/appointment/{id}/cancel', 'HomeController@appointmentCancel')->name('appointment.cancel');
    Route::get('/appointment/{id}/cancelAccepted', 'HomeController@appointmentCancelAccepted')->name('appointment.cancelAccepted');
 
    Route::get('/nurse_booking', 'HomeController@nurse_booking')->name('nurse_booking');
    Route::get('/update_nurse_booking_status', 'HomeController@update_nurse_booking_status')->name('update_nurse_booking_status');
    Route::get('/delete_nurse_booking_order/{id}', 'HomeController@delete_nurse_booking_order')->name('delete_nurse_booking_order');

    Route::group(['prefix' => 'banner'], function() {

        Route::get('/', 'BannerController@index')->name('banner.index');
        Route::get('/add', 'BannerController@create')->name('banner.create');
        Route::post('/store', 'BannerController@store')->name('banner.store');
        Route::get('/edit/{id?}', 'BannerController@edit')->name('banner.edit');
        Route::post('/update/{id}', 'BannerController@update')->name('banner.update');
        Route::get('/delete/{id?}', 'BannerController@destroy')->name('banner.delete');
        
    });


    Route::group(['prefix' => 'patient'], function() {

        Route::get('/', 'UserController@patientindex')->name('patient.index');
        Route::get('/get', 'UserController@get')->name('patient.get');
        Route::get('/add', 'UserController@addUser')->name('patient.add');
        Route::post('/store', 'UserController@storeUser')->name('patient.store');
        Route::get('/edit/{id?}', 'UserController@editUser')->name('patient.edit');
        Route::post('/update/{id}', 'UserController@updateUser')->name('patient.update');
        Route::get('/delete/{id?}', 'UserController@userdelete')->name('patient.delete');
        
    });

    Route::group(['prefix' => 'user'], function() {

        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/get', 'UserController@get')->name('user.get');
        Route::get('/add', 'UserController@addUser')->name('user.add');
        Route::post('/store', 'UserController@storeUser')->name('user.store');
        Route::get('/edit/{id?}', 'UserController@editUser')->name('user.edit');
        Route::post('/update/{id}', 'UserController@updateUser')->name('user.update');
        Route::get('/show/{id}', 'UserController@showUser')->name('user.show');
        Route::get('/delete/{id?}', 'UserController@userdelete')->name('user.delete');
        
    });

    Route::group(['prefix' => 'bedtype'], function() {

        Route::get('/', 'BedController@bedTypeIndex')->name('bedtype.index');
        Route::get('/add', 'BedController@bedTypeCreate')->name('bedtype.create');
        Route::post('/store', 'BedController@bedTypeStore')->name('bedtype.store');
        Route::get('/edit/{id?}', 'BedController@bedTypeEdit')->name('bedtype.edit');
        Route::post('/update/{id}', 'BedController@bedTypeUpdate')->name('bedtype.update');
        Route::get('/delete/{id?}', 'BedController@bedTypeDelete')->name('bedtype.delete');
        
    });

    Route::group(['prefix' => 'bed'], function() {

        Route::get('/', 'BedController@Index')->name('bedbooking.index');
        Route::get('/add', 'BedController@Create')->name('bedbooking.create');
        Route::post('/store', 'BedController@Store')->name('bedbooking.store');
        Route::get('/edit/{id?}', 'BedController@Edit')->name('bedbooking.edit');
        Route::post('/update/{id}', 'BedController@Update')->name('bedbooking.update');
        Route::get('/delete/{id?}', 'BedController@Delete')->name('bedbooking.delete');
        
    });

    Route::group(['prefix' => 'setting'], function() {

        Route::get('/', 'SettingController@index')->name('setting');
        Route::get('/profile', 'SettingController@profile_index')->name('setting.profile');
        Route::post('/appname', 'SettingController@updateappname')->name('setting.appname');
        Route::post('/logo', 'SettingController@updatelogo')->name('setting.logo');
        Route::post('/copyright', 'SettingController@updatecopyright')->name('setting.copyright');
        // Route::post('/email', 'SettingController@updateadminemail')->name('setting.email');
        // Route::post('/password', 'SettingController@updateadminpassword')->name('setting.password');

        Route::post('/app_address', 'SettingController@updatecompanyaddress')->name('setting.app_address');
        Route::post('/app_email', 'SettingController@updatecompanyemail')->name('setting.app_email');
        Route::post('/app_mobile', 'SettingController@updatecompanymobile')->name('setting.app_mobile');
        Route::post('/app_version', 'SettingController@updateappversion')->name('setting.app_version');
    });
    Route::group(['prefix' => 'profile'], function() {

        Route::get('/', 'SettingController@profile_index')->name('profile');
        Route::post('/email', 'SettingController@updateadminemail')->name('setting.email');
        Route::post('/password', 'SettingController@updateadminpassword')->name('setting.password');

    });

    Route::resource('center', CenterController::class);
    Route::get('centers/get', 'CenterController@get')->name('center.get');
    Route::resource('blog', BlogCoontroller::class);
    Route::get('blogs/pending', 'BlogCoontroller@pending')->name('blog.pending');
    Route::get('blogs/comment/{id}', 'BlogCoontroller@blogcomment')->name('blog.comment');
    Route::resource('b_category', BlogCategoryCoontroller::class);

    Route::group(['prefix' => 'content'], function() {
                
        Route::get('/appcontent', 'ContentController@app_index')->name('appcontent');
        Route::get('/appcontent/edit{id}', 'ContentController@app_content_edit')->name('appcontent.edit.app');
        Route::post('/appcontent/update', 'ContentController@app_update')->name('appcontent.app_update');
        Route::get('/appcontent/add', 'ContentController@addappcontent')->name('appcontent.app_add');
        Route::post('/appcontent/store', 'ContentController@app_store')->name('appcontent.app_store');
        Route::get('/appcontent/delete/{id}', 'ContentController@appcontentdelete')->name('appcontent.delete');

        Route::resource('faqcategory', FAQCategoryController::class);    
        Route::resource('faq', FAQController::class);
    });

    Route::group(['prefix' => 'doctor'], function() {
                
        Route::get('/', 'DoctorController@index')->name('doctor');
        Route::post('/getcity','DoctorController@getcity')->name('doctor.getcity');
        Route::post('/getentity','DoctorController@getentity')->name('doctor.getentity');
        Route::get('/add', 'DoctorController@addDoctor')->name('doctor.create');
        Route::post('/store', 'DoctorController@storeDoctor')->name('doctor.store');
        Route::get('/edit/{id}', 'DoctorController@editDoctor')->name('doctor.edit');
        Route::get('/show/{id}', 'DoctorController@showDoctor')->name('doctor.show');
        Route::post('/update/{id}', 'DoctorController@updateDoctor')->name('doctor.update');
        Route::get('/delete/{id}', 'DoctorController@deleteDoctor')->name('doctor.delete');
        Route::get('/delete/image/{id?}/{name?}', 'DoctorController@deleteclinicImage')->name('doctor.clinicimage.delete');
        Route::post('/getActivity', 'DoctorController@getActivity')->name('doctor.getActivity');
    });
    
    Route::group(['prefix' => 'enquiry'], function() {

        Route::get('/', 'EnquiryController@index')->name('enquiry');
        Route::get('/{id}', 'EnquiryController@enq_delete')->name('enquiry.delete');
        Route::get('/view/{id}', 'EnquiryController@enq_view')->name('enquiry.view');
        Route::post('/reply','EnquiryController@enquiry_reply')->name('enquiry.reply');
    });
    
    Route::group(['prefix' => 'speciality'], function() {
        Route::get('/', 'SpecialityController@index')->name('speciality.index');
        Route::get('/create', 'SpecialityController@create')->name('speciality.create');
        Route::get('/edit/{id}', 'SpecialityController@edit')->name('speciality.edit');
        Route::post('/store', 'SpecialityController@store')->name('speciality.store');
        Route::post('/update/{id}', 'SpecialityController@update')->name('speciality.update');
        Route::get('/delete/{id}', 'SpecialityController@destroy')->name('speciality.delete');
    });

    Route::group(['prefix' => 'entity'], function() {
                
        Route::get('/', 'EntityController@index')->name('entity');
        Route::get('/add', 'EntityController@addEntity')->name('entity.create');
        Route::post('/store', 'EntityController@storeEntity')->name('entity.store');
        Route::get('/edit/{id}', 'EntityController@editEntity')->name('entity.edit');
        Route::get('/show/{id}', 'EntityController@showEntity')->name('entity.show');
        Route::post('/update/{id}', 'EntityController@updateEntity')->name('entity.update');
        Route::get('/delete/{id}', 'EntityController@deleteEntity')->name('entity.delete');
        Route::get('/delete/{id}/{img}', 'EntityController@deleteImage')->name('entity.image.delete');
    });

    // Route::group(['prefix' => 'patient'], function() {
                
    //     Route::get('/', 'DoctorController@index')->name('patient');
        
    // });
    


    Route::group(['prefix' => 'service'], function() {
        Route::get('/', 'ServiceController@index')->name('service.index');
        Route::get('/create', 'ServiceController@create')->name('service.create');
        Route::get('/edit/{id}', 'ServiceController@edit')->name('service.edit');
        Route::post('/store', 'ServiceController@store')->name('service.store');
        Route::post('/update/{id}', 'ServiceController@update')->name('service.update');
        Route::get('/delete/{id}', 'ServiceController@destroy')->name('service.delete');
    });

    Route::group(['prefix' => 'area'], function() {
        Route::get('/', 'AreaController@index')->name('area.index');
        Route::get('/create', 'AreaController@create')->name('area.create');
        Route::get('/edit/{id}', 'AreaController@edit')->name('area.edit');
        Route::post('/store', 'AreaController@store')->name('area.store');
        Route::post('/update/{id}', 'AreaController@update')->name('area.update');
        Route::get('/delete/{id}', 'AreaController@destroy')->name('area.delete');
    });

    Route::group(['prefix' => 'lab_test'], function() {
        Route::get('/', 'LabTestController@index')->name('lab_test.index');
        Route::get('/create', 'LabTestController@create')->name('lab_test.create');
        Route::get('/edit/{id}', 'LabTestController@edit')->name('lab_test.edit');
        Route::post('/store', 'LabTestController@store')->name('lab_test.store');
        Route::post('/update/{id}', 'LabTestController@update')->name('lab_test.update');
        Route::get('/delete/{id}', 'LabTestController@destroy')->name('lab_test.delete');
    });

    Route::group(['prefix' => 'coupon'], function() {
        Route::get('/', 'CouponController@index')->name('coupon.index');
        Route::get('/create', 'CouponController@create')->name('coupon.create');
        Route::get('/edit/{id}', 'CouponController@edit')->name('coupon.edit');
        Route::post('/store', 'CouponController@store')->name('coupon.store');
        Route::post('/update/{id}', 'CouponController@update')->name('coupon.update');
        Route::get('/delete/{id}', 'CouponController@destroy')->name('coupon.delete');
    });

    Route::resource('product/category', ProductCategoryController::class);    
    Route::resource('product', ProductController::class);
    Route::resource('hospital', HospitalController::class);
    Route::get('/delete/hospital/image/{id?}/{name?}', 'HospitalController@deleteImage')->name('hospital.image.delete');
});