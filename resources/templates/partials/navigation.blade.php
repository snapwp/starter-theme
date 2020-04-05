<nav role="navigation" aria-label="Main navigation">
    <a href="{{ get_home_url() }}" aria-label="Back to homepage">
        {{ get_bloginfo('name') }}
    </a>

    <ul role="menubar" aria-label="Main navigation">
        @simplemenu('primary' as $item)
            <li role="none">
                <a href="{{ $item->url }}" class="{{ $item->is_active ? 'active' : '' }}" role="menuitem">
                    {{ $item->text }}
                </a>

                @if(!empty($item->children))
                    <ul role="menu" aria-label="Submenu for {{ $item->text }}">
                        @foreach($item->children as $child)
                            <li role="none">
                                <a href="{{ $child->url }}" class="{{ $child->is_active ? 'active' : '' }}" role="menuitem">
                                    {{ $child->text }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endsimplemenu
    </ul>
</nav>