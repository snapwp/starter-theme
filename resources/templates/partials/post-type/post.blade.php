@if(is_single())

    <article itemscope itemtype="http://schema.org/Article">
        {!! get_the_post_thumbnail( $post, 'post_full_width', ['class' => 'mb-3 img-fluid'] ) !!}

        <h1 itemprop="name headline">{{ $post->post_title }}</h1>

        <div itemprop="articleBody">
            @thecontent
        </div>

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