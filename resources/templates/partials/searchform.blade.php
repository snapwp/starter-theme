<form role="search" method="get" action="{{ esc_url(home_url('/')) }}">
    <input type="text" id="{{ $searchform_id }}"  placeholder="Search for..." name="s" aria-label="{{ _x( 'Search for:', 'label' ) }}" required>

    <button type="submit">
        {{ esc_attr_x('Search', 'submit button') }}
    </button>
</form>