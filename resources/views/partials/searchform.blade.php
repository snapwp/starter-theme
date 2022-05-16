<form role="search" method="get" action="{{ esc_url(home_url('/')) }}">
    <label class="block mb-2" for="{{ $searchform_id }}">Search this site...</label>

    <div class="bg-white flex justify-between border border-gray-200 rounded transition-shadow duration-300 focus-within:ring-4 focus-within:ring-slate-200">
        <input class="w-full m-1 px-4 py-2 rounded focus:border-transparent focus:outline-none" type="text" id="{{ $searchform_id }}" value="{{ get_search_query() }}" placeholder="Search for..." name="s" aria-label="{{ _x( 'Search for:', 'label' ) }}" required>

        <button type="submit" class="m-1 py-1 px-2 rounded bg-cyan-500 text-white">
            {{ esc_attr_x('Search', 'submit button') }}
        </button>
    </div>
</form>
