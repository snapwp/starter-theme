<?php

namespace Theme\Support;

/**
 * AVIF quality based on what the source image is, shared by the GD and Imagick editors.
 *
 * - Photos (jpeg sources) hide 4:2:0 chroma subsampling well, so they use the normal quality setting
 *   (Snap's `images.default_image_quality` config) for much smaller files.
 * - Graphics (png and anything else) have flat colours and hard coloured edges that visibly bleed at 4:2:0,
 *   so they never go below AVIF_GRAPHIC_QUALITY - libgd only switches to 4:4:4 at quality >= 90.
 */
trait NextGenQuality
{
    public const AVIF_GRAPHIC_QUALITY = 90;

    /**
     * The mime type the editor was loaded with. Imagick's save() overwrites $this->mime_type with the
     * output type, so it can't be relied on after the first save.
     */
    private ?string $sourceMime = null;

    protected function rememberSourceMime(): void
    {
        $this->sourceMime = $this->mime_type;
    }

    protected function isPhoto(): bool
    {
        return 'image/jpeg' === ($this->sourceMime ?? $this->mime_type);
    }

    public function set_quality($quality = null, $dims = [])
    {
        $result = parent::set_quality($quality, $dims);

        // Applied after `wp_editor_set_quality`, as Snap's config sets one quality for every image type.
        if (null === $quality && true === $result && $this->isGraphicAvif() && $this->quality < self::AVIF_GRAPHIC_QUALITY) {
            return parent::set_quality(self::AVIF_GRAPHIC_QUALITY, $dims);
        }

        return $result;
    }

    private function isGraphicAvif(): bool
    {
        return 'image/avif' === ($this->output_mime_type ?: $this->mime_type) && !$this->isPhoto();
    }
}
