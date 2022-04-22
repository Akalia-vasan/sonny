<?php

namespace App\Providers;

use Auth;
use Exception;
use App\Models\User;
use App\Models\Setting;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        try
        {
            $data = Setting::get();

            $settings = [];

            foreach ($data as $item)
            {
                $settings[$item->key] = $item->value;
            }

            $settings = (Object) $settings;
           // dd($settings);
            View::share('settings', $settings);
        }
        catch(Exception $e) {}

        Validator::extend('check_password', function($attribute, $value, $parameters)
        {     
           
            if(!Hash::check($value ,auth()->user()->password) )
            {
                return false;
            }
            return true;
        });
        
        Validator::extend('check_user', function($attribute, $value, $parameters)
        { 
            return User::where('id',$value)->count();
        });
        Validator::extend('check_doctor', function($attribute, $value, $parameters)
        { 
            return Doctor::where('id',$value)->count();
        });
    }
}
