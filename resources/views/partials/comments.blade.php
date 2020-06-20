@if(have_comments())

    <div id="comments" class="comments">
        <h3 class="comments__title">Comments</h3>

        <ul class="comments__list">
            <?php wp_list_comments(); ?>
        </ul>

        @if(get_comment_pages_count() > 1 && get_option('page_comments'))
            <nav class="comments__navigation" role="navigation" aria-label="Comment section navigation">
                <div class="nav-previous">{!! get_previous_comments_link(__('&larr; Older Comments', 'theme')) !!}</div>
                <div class="nav-next">{!! get_next_comments_link(__('Newer Comments &rarr;', 'theme')) !!}</div>
            </nav>
        @endif

        @if(!comments_open() && get_comments_number())
            <p>{{ __('Comments are closed.', 'theme') }}</p>
        @endif
    </div>

@endif

<?php comment_form(); ?>

