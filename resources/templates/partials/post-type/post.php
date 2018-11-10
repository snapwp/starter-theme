<?php if (is_single()) : ?>

	<article>
		<?php the_post_thumbnail( 'post_featured_image', [ 'class' => 'mb-3 img-fluid' ] ); ?>

		<h1><?php the_title(); ?></h1>

        <?php the_content(); ?>
	</article>

<?php else : ?>

	<article <?php post_class(); ?>>
		<?php the_post_thumbnail( 'post_featured_image', [ 'class' => 'card-img-top img-fluid' ] ); ?>

		<h4><?php the_title(); ?></h4>

		<?php the_excerpt(); ?>

		<a href="<?php the_permalink(); ?>">Read more</a>
	</article>

<?php endif; ?>