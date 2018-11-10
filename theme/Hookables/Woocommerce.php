<?php

namespace Theme\Hookables;

use Snap\Core\Hookable;

/**
 * WooCommerce functionality and enable Snap routing to work with WoocCommerce.
 * 
 * Feel free to delete this file if you are not using WooCommerce.
 */
class Woocommerce extends Hookable
{
	/**
     * Filters to add on init.
     *
     * @var array
     */
    protected $filters = [
    	'woocommerce_template_loader_files' => 'enable_snap_route_support'
    ];

    /**
     * Enable WooCommerce to work with Snap routes.
     * 
     * Normally WooCommerce searches your theme for a woocommerce.php.
     * This method tells Woo to load the Snap routes file before this, allowing you to define routes for WooCommerce as you would
     * for normal WordPress routes.
     *
     * If you prefer to use the woocomemrce.php or the woocommerce directory for direct overrides, delete this filter.
     *
     * @see  http://snapwp.io/docs/woocommerce
     *
     * @since  1.0.0
     * 
     * @param  array  $templates        Array of files for WooCommerce to look for.
     * @param  string $current_template The current WooCommerce template.
     * @return array
     */
    public function enable_snap_route_support($templates, $current_template)
    {
        return ['resources/routes.php'] + $templates;
    }
}