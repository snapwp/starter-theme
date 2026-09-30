<?php

namespace Theme\Hookables;

use Snap\Core\Hookable;
use Theme\Support\AvifChecker;
use Theme\Support\ColourProfile;
use Theme\Support\ImageEditorGd;
use Theme\Support\ImageEditorImagick;

class Media extends Hookable
{
    public function boot(): void
    {
        $this->addFilter('image_editor_output_format', 'convertUploadsToNextGen', 10, 3);
        $this->addFilter('wp_image_editors', 'useCustomEditors');
    }

    /**
     * Swap core's editors for our subclasses. Core tries Imagick first and falls back to GD.
     */
    public function useCustomEditors(array $editors): array
    {
        $replacements = [
            \WP_Image_Editor_Imagick::class => ImageEditorImagick::class,
            \WP_Image_Editor_GD::class => ImageEditorGd::class,
        ];

        return array_map(fn($editor) => $replacements[$editor] ?? $editor, $editors);
    }

    /**
     * Convert jpeg/png uploads to AVIF when supported. Without AVIF support, only jpegs go to WebP -
     * PNGs are often smaller than their WebP equivalent.
     */
    public function convertUploadsToNextGen(array $formats, ?string $filename = null, ?string $mime_type = null): array
    {
        if ($filename && !$this->canKeepColours($filename)) {
            return $formats;
        }

        if (AvifChecker::canConvertAvif()) {
            $formats['image/jpeg'] = 'image/avif';
            $formats['image/png'] = 'image/avif';
        } else {
            $formats['image/jpeg'] = 'image/webp';
        }

        return $formats;
    }

    /**
     * Imagick carries ICC profiles through to AVIF/WebP. GD drops them, so leave images with a non-sRGB
     * profile in their original format rather than silently shifting their colours.
     */
    private function canKeepColours(string $filename): bool
    {
        return AvifChecker::imagickSupportsAvif() || ColourProfile::isSrgb($filename);
    }
}
