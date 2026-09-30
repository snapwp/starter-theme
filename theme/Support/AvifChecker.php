<?php


namespace Theme\Support;

class AvifChecker
{
    /**
     * Checks if the active ImageMagick extension supports AVIF encoding.
     */
    public static function imagickSupportsAvif(): bool
    {
        if (!class_exists('\Imagick')) {
            return false;
        }

        try {
            $formats = \Imagick::queryFormats('AVIF');
            return !empty($formats);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Checks if the active GD extension supports AVIF encoding.
     */
    public static function gdSupportsAvif(): bool
    {
        return function_exists('imageavif') && function_exists('imagecreatefromavif');
    }

    /**
     * Determines if the server can safely handle AVIF conversions.
     */
    public static function canConvertAvif(): bool
    {
        return self::imagickSupportsAvif() || self::gdSupportsAvif();
    }
}