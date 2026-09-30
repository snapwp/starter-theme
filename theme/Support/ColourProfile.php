<?php

namespace Theme\Support;

/**
 * Reads the embedded ICC profile from a JPEG or PNG without needing Imagick.
 *
 * Used to spot images whose colours depend on a non-sRGB profile (Display P3 screenshots, Adobe RGB
 * photos, CMYK jpegs...). GD drops profiles, so converting those would shift their colours.
 */
class ColourProfile
{
    /**
     * True when the image has no profile (browsers assume sRGB) or an sRGB one.
     */
    public static function isSrgb(string $file): bool
    {
        $icc = self::extract($file);

        if (null === $icc) {
            return true;
        }

        if (strlen($icc) < 132 || substr($icc, 16, 4) !== 'RGB ') {
            return false;
        }

        return stripos(self::description($icc), 'srgb') !== false;
    }

    public static function extract(string $file): ?string
    {
        $data = @file_get_contents($file);

        if (false === $data) {
            return null;
        }

        if (str_starts_with($data, "\x89PNG\r\n\x1a\n")) {
            return self::fromPng($data);
        }

        if (str_starts_with($data, "\xFF\xD8")) {
            return self::fromJpeg($data);
        }

        return null;
    }

    private static function fromPng(string $data): ?string
    {
        $offset = 8;
        $length = strlen($data);

        while ($offset + 8 <= $length) {
            $size = unpack('N', substr($data, $offset, 4))[1];
            $type = substr($data, $offset + 4, 4);

            // An sRGB chunk, or reaching image data before any profile, means there's no custom profile.
            if ('sRGB' === $type || 'IDAT' === $type) {
                return null;
            }

            if ('iCCP' === $type) {
                $chunk = substr($data, $offset + 8, $size);
                $name_end = strpos($chunk, "\0");
                $icc = false === $name_end ? false : @gzuncompress(substr($chunk, $name_end + 2));

                return false === $icc ? null : $icc;
            }

            $offset += 12 + $size;
        }

        return null;
    }

    private static function fromJpeg(string $data): ?string
    {
        $offset = 2;
        $length = strlen($data);
        $parts = [];

        while ($offset + 4 <= $length && "\xFF" === $data[$offset]) {
            $marker = ord($data[$offset + 1]);

            // Start of scan: no more metadata segments.
            if (0xDA === $marker) {
                break;
            }

            $size = unpack('n', substr($data, $offset + 2, 2))[1];

            // APP2 "ICC_PROFILE\0" + sequence number + total count + chunk.
            if (0xE2 === $marker && substr($data, $offset + 4, 12) === "ICC_PROFILE\0") {
                $parts[ord($data[$offset + 16])] = substr($data, $offset + 18, $size - 16);
            }

            $offset += 2 + $size;
        }

        if (!$parts) {
            return null;
        }

        ksort($parts);

        return implode('', $parts);
    }

    /**
     * Reads the profile's 'desc' tag (v2 'desc' or v4 'mluc' type).
     */
    private static function description(string $icc): string
    {
        $count = unpack('N', substr($icc, 128, 4))[1];

        for ($i = 0; $i < $count; $i++) {
            $entry = substr($icc, 132 + $i * 12, 12);

            if (strlen($entry) < 12 || substr($entry, 0, 4) !== 'desc') {
                continue;
            }

            ['o' => $offset, 's' => $size] = unpack('No/Ns', substr($entry, 4, 8));
            $tag = substr($icc, $offset, $size);

            if (str_starts_with($tag, 'desc')) {
                $len = unpack('N', substr($tag, 8, 4))[1];

                return rtrim(substr($tag, 12, $len), "\0");
            }

            if (str_starts_with($tag, 'mluc')) {
                ['l' => $len, 'o' => $str] = unpack('Nl/No', substr($tag, 20, 8));

                return (string) mb_convert_encoding(substr($tag, $str, $len), 'UTF-8', 'UTF-16BE');
            }
        }

        return '';
    }
}
