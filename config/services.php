<?php

return [
    /**
     * External service providers.
     * These are run during the Snap initialization process.
     *
     * @var array
     */
    'providers' => [
        Snap\Debug\DebugServiceProvider::class,
    ],

    /**
     * Register your theme's providers.
     * These are run after Snap has been initialized.
     *
     * @var array
     */
    'theme_providers' => [
        \Theme\Providers\ThemeProvider::class
    ],

    /**
     * Alias a given class to another class.
     *
     * Useful for making namespaced classes available in templates without typing the full namespace.
     *
     * @var array
     */
    'aliases' => [
    ],
];