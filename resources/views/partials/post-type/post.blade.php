@if(is_single())
    <article>
        {!! get_the_post_thumbnail( $post, 'post_full_width' ) !!}

        <h1>{{ $post->post_title }}</h1>

        @thecontent
    </article>
@else
    <article>
        {!! get_the_post_thumbnail( $post, 'post_featured_image' ) !!}

        <div>
            <h4>{{ $post->post_title }}</h4>

            @theexcerpt

            <a href="{{ get_the_permalink() }}">Read more</a>
        </div>
    </article>
@endif
