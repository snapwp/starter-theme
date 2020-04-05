<?php

namespace Theme\Content\PostTypes;

use Snap\Hookables\PostType;

/**
 * Post description
 */
class Page extends PostType
{
    protected $singular = 'Page';

    /**
     * Override the plural name.
     *
     * @var string
     */
    protected $plural = 'Pages';

    /**
     * Override the post type default options.
     *
     * @var array
     */
    protected $options = [
        //
    ];

    /**
     * Run after the post type is registered.
     */
    public function boot()
    {
        //$this->columns()->add('example_column', 'Example Column');
    }
}
