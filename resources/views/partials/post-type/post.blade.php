@if(is_single())
    <article class="prose lg:prose-xl mx-auto">
        {!! get_the_post_thumbnail( $post, 'post_full_width', ['class' => 'w-full object-cover'] ) !!}

        <h1>{{ $post->post_title }}</h1>

        @thecontent
    </article>
@else
    <article class="mb-12">
        <div>
            <h4 class="text-3xl mb-1"><a href="{{ get_the_permalink() }}">{{ $post->post_title }}</a></h4>

            <div class="mb-1">
                @theexcerpt
            </div>
        </div>
    </article>
@endif
