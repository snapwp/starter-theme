<?php

return [
    /**
     * Whether to use the asset version strings added by wp_enqueue_script/style functions.
     *
     * @var bool
     */
    'remove_asset_versions' => true,

    /**
     * If true, then snap will put defer="true" on enqueued javascript.
     *
     * @var bool
     */
    'defer_scripts' => true,

    /**
     * An array of the script handles to not add defer to.
     *
     * Very useful for jQuery if a plugin adds inline js which relies on jQuery existing globally.
     *
     * @var array
     */
    'defer_scripts_skip' => [
        'vite',
    ],

    /**
     * Completely disable all front end jQuery.
     *
     * Generally not a good idea as a lot of plugins depend on it, so use with caution.
     *
     * @var bool
     */
    'disable_jquery' => true,

    /**
     * If not false, then load this version of jquery via the Google CDN instead of the WP jQuery version.
     *
     * Ignored if disable_jquery is true.
     *
     * @var string|false
     */
    'use_jquery_cdn' => '3.3.1',

    /**
     * The path to the manifest created by vite/webpack etc.
     * @var string
     */
    'manifest_path' => '/public/manifest.json'
];