<?php

namespace App\Providers;

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
        $frontendModels = [
            \App\Models\Product::class,
            \App\Models\Category::class,
            \App\Models\SubCategory::class,
            \App\Models\SubSubcategory::class,
            \App\Models\Brand::class,
            \App\Models\ProductType::class,
            \App\Models\Slider::class,
            \App\Models\Announcement::class,
        ];

        foreach ($frontendModels as $model) {
            $model::observe(\App\Observers\FrontendCacheObserver::class);
        }
    }
}
