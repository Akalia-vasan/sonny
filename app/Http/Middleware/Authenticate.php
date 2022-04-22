<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected $guards;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = empty($guards) ? [null] : $guards;

        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
           
            foreach ($this->guards as $guard) 
            {
                if($guard == 'admin')
                {                 
                    return route('admin.login');
                }
                elseif($guard == 'doctor')
                {                 
                    return route('doctor.login');
                }
                else
                {
                    return route('loginview');
                }
            }
        }
    }
}
