@props(['id', 'size' => 'full'])

{!! wp_get_attachment_image($id, $size, false, $attributes->getAttributes()) !!}