<article class="prose lg:prose-xl mx-auto">
    <h1>{{ $post->post_title }}</h1>

    {!! get_the_post_thumbnail($post, 'post_full_width', ['class' => 'mb-3 img-fluid']) !!}

    @thecontent
</article>
