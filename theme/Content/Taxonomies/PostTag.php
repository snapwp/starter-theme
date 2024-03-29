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
     */
    public ?string $name = 'post_tag';

    /**
     * Override the singular name.
     */
    public ?string $singular = 'Tag';

    /**
     * Override the plural name.
     */
    public ?string $plural = 'Tags';

   /**
    * Post types to register this taxonomy for.
    */
   protected array $post_types = [

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
