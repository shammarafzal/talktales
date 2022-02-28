<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $users = User::where('is_Admin', 0)->get();
        // $orders = Booking::all();
        View::share([
            'users' => $users,
            'orders' => $users,
        ]);
    }
}
