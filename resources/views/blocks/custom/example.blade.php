{{--
Description: Just an example block.
Icon: media-document
Keywords: example, custom
Post types: page
Multiple: false
--}}

@if($is_preview)
    <p>Editor context</p>
@else
    <p>Frontend context</p>
@endif