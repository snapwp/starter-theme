<?php

return [
    /**
     * If true sets the `xmlrpc_enabled` filter to return false.
     * XMLRPC is only really used these days if JetPack is installed, and can otherwise be a potential security hole.
     *
     * @var bool
     */
	'disable_xmlrpc' => true,


    /**
     * Disable comments site wide.
     *
     * @var bool
     */
    'disable_comments' => true,


    /**
     * Disable the customizer in the admin.
     *
     * @var bool
     */
    'disable_customizer' => true,


    /**
     * Disable Post Tags because they suck.
     *
     * @var bool
     */
    'disable_tags' => true,


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
        //'jquery',
    ],


    /**
     * Completely disable all front end jQuery.
     *
     * Generally not a good idea as a lot of plugins depend on it, so use with caution.
     *
     * @var bool
     */
    'disable_jquery' => false,


    /**
     * If not false, then load this version of jquery via the Google CDN instead of the WP jQuery version.
     *
     * Ignored if disable_jquery is true.
     *
     * @var string|false
     */
    'use_jquery_cdn' => '3.3.1',
];