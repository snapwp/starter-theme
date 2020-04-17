<?php

namespace Theme;

use Snap\Hookables\Theme;

/**
 * Setup theme.
 *
 * This means registering scripts, sidebars and menus.
 */
class Bootstrap extends Theme
{
    /**
     * Declare theme support.
     *
     * Keys are the feature to enable, and values are any additional arguments to pass to add_theme_support().
     *
     * @var array
     */
    protected $supports = [
        'html5' => ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption'],

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
     * Boot up your theme!
     */
    public function boot(): void
    {
        $this->addAction('widgets_init', 'registerThemeWidgets');
        $this->addAction('wp_enqueue_scripts', 'enqueueThemeAssets');
    }

    /**
     * Enqueue the theme CSS files.
     */
    public function enqueueThemeAssets(): void
    {
        wp_enqueue_style('theme-styles', snap_get_asset_url('/css/style.css'));
        wp_enqueue_script('theme-scripts', snap_get_asset_url('/scripts/theme.js'), ['jquery'], false, true);
    }

    /**
     * Register the theme's widgets.
     */
    public function registerThemeWidgets(): void
    {
        register_sidebar([
            'name' => __('Sidebar', 'snap'),
            'id' => 'sidebar-main',
            'description' => __('Widgets in this area will be shown on all content', 'snap'),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        ]);
    }
}
