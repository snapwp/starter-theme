<?php

namespace Theme\Support;

use WP_Image_Editor_GD;

/**
 * GD fixes for next-gen (AVIF/WebP) output.
 *
 * - imagewebp()/imageavif() can't encode palette (indexed) images and leave a 0 byte file behind.
 *   Core only converts truecolor <-> palette for its PNG branch, so upgrade to truecolor on load
 *   (a no-op for images that are already truecolor, e.g. most jpegs).
 * - AVIF quality depends on the source (see NextGenQuality). libgd picks chroma subsampling from quality
 *   alone (4:4:4 at >= 90, 4:2:0 below), so graphics get 4:4:4 and photos 4:2:0 automatically.
 * - GD can't read or write ICC profiles, so converting an image with a non-sRGB profile (Display P3,
 *   Adobe RGB, CMYK...) would shift its colours. Those are saved in their original format instead.
 */
class ImageEditorGd extends WP_Image_Editor_GD
{
    use NextGenQuality;

    private bool $keepSourceFormat = false;

    public function load(): bool|\WP_Error
    {
        $loaded = parent::load();

        if (!is_wp_error($loaded)) {
            $this->rememberSourceMime();
            $this->keepSourceFormat = !ColourProfile::isSrgb($this->file);
        }

        if (!is_wp_error($loaded) && is_gd_image($this->image) && !imageistruecolor($this->image)) {
            imagepalettetotruecolor($this->image);
        }

        return $loaded;
    }

    protected function get_output_format($filename = null, $mime_type = null)
    {
        if (!$this->keepSourceFormat) {
            return parent::get_output_format($filename, $mime_type);
        }

        $skip = fn(array $formats) => array_diff_key($formats, [$this->mime_type => true]);

        add_filter('image_editor_output_format', $skip, PHP_INT_MAX);

        try {
            return parent::get_output_format($filename, $mime_type);
        } finally {
            remove_filter('image_editor_output_format', $skip, PHP_INT_MAX);
        }
    }
}
