<?php

namespace Theme\Support;

/**
 * Tunes next-gen output (AVIF/WebP) so colours survive conversion.
 *
 * Note: WP_Image_Editor_Imagick never calls make_image() - it writes files via
 * a private write_image() from _save() - so that's the method we hook into.
 */
class ImageEditorImagick extends \WP_Image_Editor_Imagick
{
    use NextGenQuality;

    public function load()
    {
        $loaded = parent::load();

        if (!is_wp_error($loaded)) {
            $this->rememberSourceMime();
        }

        return $loaded;
    }

    protected function _save($image, $filename = null, $mime_type = null)
    {
        [, , $output_mime] = $this->get_output_format($filename, $mime_type);

        if ('image/avif' === $output_mime || 'image/webp' === $output_mime) {
            try {
                $this->prepareColour($image);

                if ('image/avif' === $output_mime) {
                    // Match libgd: 4:2:0 is fine for photos, but makes flat colours and coloured edges bleed in graphics.
                    $image->setOption('heic:chroma', $this->isPhoto() ? '420' : '444');
                } else {
                    // Slowest/smallest WebP encode.
                    $image->setOption('webp:method', '6');
                }
            } catch (\Exception $e) {
                // Fall back to core behaviour if the delegate doesn't support an option.
            }
        }

        return parent::_save($image, $filename, $mime_type);
    }

    /**
     * AVIF/WebP are RGB only. Convert CMYK sources to sRGB and drop the (now wrong) CMYK profile.
     * Any RGB ICC profile (Display P3, Adobe RGB...) is left in place - WP's strip_meta() keeps it and
     * ImageMagick embeds it in the output, so browsers render the same colours as the original.
     */
    private function prepareColour(\Imagick $image): void
    {
        if ($image->getImageColorspace() !== \Imagick::COLORSPACE_CMYK) {
            return;
        }

        $image->transformImageColorspace(\Imagick::COLORSPACE_SRGB);

        if (!empty($image->getImageProfiles('icc', true))) {
            $image->removeImageProfile('icc');
        }
    }
}
