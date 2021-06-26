<?php

namespace Theme\Content\PostTypes;

use Snap\Hookables\PostType;

/**
 * Post model
 */
class Post extends PostType
{
    protected ?string $singular = 'Post';

    /**
     * Override the plural name.
     */
    protected ?string $plural = 'Posts';

    /**
     * Override the post type default options.
     */
    protected array $options = [
        //
    ];

    /**
     * Run after the post type is registered.
     */
    public function boot(): void
    {
        //$this->columns()->add('example_column', 'Example Column');
    }
}
