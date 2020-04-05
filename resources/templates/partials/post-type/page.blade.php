<article>
	{!! get_the_post_thumbnail( $post, 'post_featured_image', [ 'class' => 'mb-3 img-fluid' ] ) !!}

	<h1 itemprop="name headline">{{ $post->post_title }}</h1>
		
	@thecontent

</article>
