<?php

namespace App\Providers;

use App\Models\Anneeacademique;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        $menu = Menu::where("menu_id", "=", null)->get();
        View::share("menu", $menu);


        $annee = Anneeacademique::where("active", "=", true)->first();
        View::share("anneeActive", $annee);
    }
}
