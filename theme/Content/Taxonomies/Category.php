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
     *
     * @var string
     */
    public $plural = 'Categories';

   /**
    * Post types to register this taxonomy for.
    *
    * @var array
    */
    protected $post_types = [
       'post'
    ];

   /**
    * Override the post type default options.
    *
    * @see https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
    * @var array
    */
   public $options = [
       //
   ];

   /**
    * Run after the taxonomy is registered.
    */
   public function boot()
   {
       //$this->columns()->add('example_column', 'Example Column');
   }
}
