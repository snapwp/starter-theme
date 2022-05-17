@extends('layouts.main')

@section('main')
	<div class="flex justify-center gap-4 lg:gap-6 lg:w-10/12 mx-auto">
		<main class="lg:w-3/4 xl:w-2/3">
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

		@if(is_active_sidebar('sidebar-main'))
			<aside class="w-1/4">
				@sidebar('sidebar-main')
			</aside>
		@endif
	</div>
@endsection