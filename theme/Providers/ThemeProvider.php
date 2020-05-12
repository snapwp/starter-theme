<?php

namespace Theme\Providers;

use Snap\Services\ServiceProvider;

/**
 * Theme service provider.
 */
class ThemeProvider extends ServiceProvider
{
    /**
     * Register any services you theme uses into the service container.
     */
    public function register(): void
    {
        // Container::add(Example::class, function() {
        //     return new Example();
        // });

        // View::share('dog', 'bar');

        // View::when('partials.post-type.post', function($view){
        //     $view->addData('dick', 'weasel');
        // });

        // Snap\Services\Blade::if('black', function() {
        //
        // });
    }
}
