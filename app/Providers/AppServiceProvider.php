<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Assuming you have logic to determine the user role
        View::composer('*', function ($view) {
            $userRole = Auth::check() && Auth::user()->account_id == 1 ? 'admin' : 'user';
            $view->with('userRole', $userRole);
        });
    }
}
