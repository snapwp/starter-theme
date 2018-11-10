<?php

namespace Theme\Hookables;

use Snap\Core\Hookable;

/**
 * Set the themes locale.
 *
 * If your theme does not require translations, feel free to delete this Hookable.
 * @link  https://developer.wordpress.org/themes/functionality/internationalization/
 */
class I18n extends Hookable
{
    /**
     * Actions to add on init.
     *
     * @since 1.0.0
     * @var array
     */
    protected $filters = [
        'locale' => 'set_locale',
        'after_setup_theme' => 'register_theme_domain'
    ];

    /**
     * The preferred way to set the locale of the site.
     *
     * @since  1.0.0
     * @link  https://codex.wordpress.org/Plugin_API/Filter_Reference/locale
     *
     * @param  string $locale The current WP locale.
     * @return string The new locale.
     */
    public function set_locale($locale)
    {
        return $locale;
    }

    /**
     * Load the translation directory when the theme is active.
     *
     * @since  1.0.0
     */
    public function register_theme_domain()
    {
        \load_theme_textdomain( 'theme', \get_template_directory() . '/languages' );
    }
}
