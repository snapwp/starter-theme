<?php

namespace Theme\Content\PostTypes;

use Snap\Hookables\PostType;

/**
 * Basic page model
 */
class Page extends PostType
{
    protected ?string $singular = 'Page';

    /**
     * Override the plural name.
     */
    protected ?string $plural = 'Pages';

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
