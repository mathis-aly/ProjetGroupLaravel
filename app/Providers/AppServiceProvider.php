<?php



namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot(): void
    {
    View::composer('components.layouts.public', function ($view) {
        $view->with('navCategories', Cache::rememberForever('categories', fn () => 
            Category::orderBy('name')->get()
        ));
    });
}

}
