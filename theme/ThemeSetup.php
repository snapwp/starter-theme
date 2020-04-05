<?php

namespace Theme;

/**
 * Setup theme.
 *
 * This means registering scripts, sidebars and menus.
 */
class ThemeSetup extends \Snap\Hookables\Theme
{
    /**
     * Declare theme support.
     *
     * Keys are the feature to enable, and values are any additional arguments to pass to add_theme_support().
     *
     * @var array
     */
    protected $supports = [
        'html5' => [
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption'
        ],

        // Remove annoying gutenberg features
        'editor-color-palette',
        'disable-custom-colors',
        'editor-font-sizes',
        'disable-custom-font-sizes',
        'responsive-embeds',
    ];

    /**
     * Declare theme menus.
     *
     * @var array
     */
    protected $menus = [
        'primary' => 'The primary navigation for the site',
    ];

    /**
     * Enqueue the theme CSS files.
     */
    public function enqueue_theme_assets()
    {
        wp_enqueue_style('bootstrap', snap_get_asset_url('/css/style.css'));
        wp_enqueue_script('bootstrap', snap_get_asset_url('/scripts/theme.js'), ['jquery'], false, true);
    }

    /**
     * Register the theme's widgets.
     */
    public function register_theme_widgets()
    {
        register_sidebar([
            'name' => __('Sidebar', 'snap'),
            'id' => 'sidebar-main',
            'description' => __('General sidebar for the website.', 'snap'),
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ]);
    }
}
