<?php

namespace Theme\Content\PostTypes;

use Snap\Hookables\PostType;

/**
 * Post description
 */
class Post extends PostType
{
    protected $singular = 'Post';

    /**
     * Override the plural name.
     *
     * @var string
     */
    protected $plural = 'Posts';

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
