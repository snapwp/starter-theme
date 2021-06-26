<article>
    {!! get_the_post_thumbnail($post, 'post_full_width', ['class' => 'mb-3 img-fluid']) !!}

    <h1>{{ $post->post_title }}</h1>

    @thecontent
</article>
