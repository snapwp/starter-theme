@extends('layouts.main')

@section('main')
	<main>
		@if(have_posts())
			@loop
				{{-- This is a shortcut to render the current partials.post-type.{get_post_type()} --}}
				@posttypepartial
			@endloop

			@paginate
		@else
			<x-no-content />
		@endif
	</main>
@endsection