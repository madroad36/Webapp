<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerService extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'frontend.app',
            ],
            'App\Http\ViewComposers\Frontend\HeaderComposer'
        );
        view()->composer(
            [
                'auth.register',

            ],
            'App\Http\ViewComposers\Frontend\RegisterComposer'
        );
        view()->composer(
            [
                'layouts.backend.sidebar',

            ],
            'App\Http\ViewComposers\Backend\NotificationComposer'
        );
        view()->composer(
            [
                'profile.app',

            ],
            'App\Http\ViewComposers\Frontend\ProfileComposer'
        );
        view()->composer(
            [
                'profile.product.view',

            ],
            'App\Http\ViewComposers\Frontend\ProfileComposer'
        );
        view()->composer(
            [
                'profile.property.view',

            ],
            'App\Http\ViewComposers\Frontend\ProfileComposer'
        );
        view()->composer(
            [
                'profile.property.owner',

            ],
            'App\Http\ViewComposers\Frontend\ProfileComposer'
        );
        view()->composer(
            [
                'profile.property.edit',

            ],
            'App\Http\ViewComposers\Frontend\ProfileComposer'
        );
        view()->composer(
            [
                'property.search',

            ],
            'App\Http\ViewComposers\Frontend\PropertyComposer'
        );
        view()->composer(
            [
                'property.show',

            ],
            'App\Http\ViewComposers\Frontend\PropertyComposer'
        );
        view()->composer(
            [
                'profile.property.create',

            ],
            'App\Http\ViewComposers\Frontend\PropertyComposer'
        );
        view()->composer(
            [
                'property.index',

            ],
            'App\Http\ViewComposers\Frontend\PropertyComposer'
        );
        view()->composer(
            [
                'profile.app',

            ],
            'App\Http\ViewComposers\Frontend\PropertyComposer'
        );
        view()->composer(
            [
                'profile.app',
            ],
            'App\Http\ViewComposers\Frontend\HeaderComposer'
        );

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
