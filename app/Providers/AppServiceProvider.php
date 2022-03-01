<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Books;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        $users = User::where('is_Admin', 0)->get();
        $books = Books::all();
        View::share([
            'users' => $users,
            'books' => $books,
        ]);
    }
}
