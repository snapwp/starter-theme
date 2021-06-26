<?php

namespace Theme\Content\Taxonomies;

use Snap\Hookables\Taxonomy;

/**
 * Allows you to easily modify the category taxonomy.
 */
class Category extends Taxonomy
{
    /**
     * Override the plural name.
     */
    public ?string $plural = 'Categories';

   /**
    * Post types to register this taxonomy for.
    */
    protected array $post_types = [
       'post'
    ];

   /**
    * Override the post type default options.
    *
    * @see https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
    */
   public array $options = [
       //
   ];

   /**
    * Run after the taxonomy is registered.
    */
   public function boot(): void
   {
       //$this->columns()->add('example_column', 'Example Column');
   }
}
