@if(is_single())

    <article itemscope itemtype="http://schema.org/Article">
        {!! get_the_post_thumbnail( $post, 'size_200', ['class' => 'mb-3 img-fluid'] ) !!}

        <h1 itemprop="name headline">{{ $post->post_title }}</h1>

        <div itemprop="articleBody">
            @thecontent
        </div>

    </article>

@else

    <article class="card mb-4">
        {!! get_the_post_thumbnail( $post, 'post_full_width', ['class' => 'card-img-top img-fluid'] ) !!}

        <div class="card-body">
            <h4 class="card-title">{{ $post->post_title }}</h4>

            @theexcerpt

            <a href="{{ get_the_permalink() }}" class="btn btn-outline-primary">Read more</a>
        </div>
    </article>

@endif