<?php

namespace Theme\Content\Taxonomies;

use Snap\Hookables\Taxonomy;

/**
 * Allows you to easily modify the post_tag taxonomy.
 */
class PostTag extends Taxonomy
{
    /**
     * Set the taxonomy name.
     *
     * @var string
     */
    public $name = 'post_tag';

    /**
     * Override the singular name.
     *
     * @var string
     */
    public $singular = 'Tag';

    /**
     * Override the plural name.
     *
     * @var string
     */
    public $plural = 'Tags';

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
