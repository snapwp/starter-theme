<article>
	<?php the_post_thumbnail( 'post_featured_image', [ 'class' => 'mb-3 img-fluid' ] ); ?>

	<h1><?php the_title(); ?></h1>

	<?php the_content(); ?>
</article>
