<?php

namespace Theme\Hookables;

use Snap\Core\Hookable;
use Snap\Utils\Theme;

class ACF extends Hookable
{
    public function boot(): void
    {
        if (function_exists('acf_add_options_page')) {
            $this->addAction('acf/init', 'registerOptionsPages');
        }

        $this->addFilter('acf/settings/save_json', 'acfJsonSavePath');
        $this->addFilter('acf/json/save_file_name', 'acfJsonFileName');
        $this->addFilter('acf/settings/load_json', 'acfJsonSavePath');
    }

    /**
     * Register ACF options pages.
     */
    public function registerOptionsPages(): void
    {
        $parent = acf_add_options_page([
            'page_title' => __('Site General Settings'),
            'menu_title' => __('Site Settings'),
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'position' => 59,
        ]);

        acf_add_options_sub_page([
            'page_title' => __('General'),
            'menu_title' => __('General'),
            'parent_slug' => $parent['menu_slug'],
        ]);

        acf_add_options_sub_page([
            'page_title' => __('Contact Information'),
            'menu_title' => __('Contact Information'),
            'parent_slug' => $parent['menu_slug'],
        ]);
    }

    /**
     * Save ACF JSON to theme resources folder.
     */
    public function acfJsonSavePath(): string
    {
        return Theme::getActiveThemePath('resources/acf');
    }

    /**
     * Save ACF JSON files with post title as filename.
     */
    public function acfJsonFileName($filename, $post): string
    {
        return sanitize_title($post['title']) . '.json';
    }
}