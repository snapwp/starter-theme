<?php

namespace Theme\Support;

/**
 * Adds an sRGB 'colr' (nclx) property to AVIF files written by PHP's bundled libgd.
 *
 * libgd encodes sRGB (BT.709 primaries, sRGB transfer, BT.601 matrix, full range) but only records it
 * inside the AV1 bitstream, not in the container. Viewers that only read the container's colour
 * property fall back to their own defaults and render shifted colours. libavif/ImageMagick output
 * always carries this box, so this just brings GD output in line.
 */
class AvifColour
{
    public static function addSrgbNclx(string $file): bool
    {
        $data = @file_get_contents($file);

        if (false === $data || substr($data, 4, 4) !== 'ftyp') {
            return false;
        }

        $top = self::parse($data, 0, strlen($data));
        $metaIndex = self::find($top, 'meta');

        if (null === $metaIndex) {
            return false;
        }

        $meta = $top[$metaIndex];
        $metaHeader = substr($meta['body'], 0, 4); // FullBox version + flags.
        $children = self::parse($meta['body'], 4, strlen($meta['body']));

        $iprp = self::find($children, 'iprp');
        $iloc = self::find($children, 'iloc');
        $pitm = self::find($children, 'pitm');

        if (null === $iprp || null === $iloc || null === $pitm) {
            return false;
        }

        $props = self::parse($children[$iprp]['body'], 0, strlen($children[$iprp]['body']));
        $ipco = self::find($props, 'ipco');
        $ipma = self::find($props, 'ipma');

        if (null === $ipco || null === $ipma) {
            return false;
        }

        $properties = self::parse($props[$ipco]['body'], 0, strlen($props[$ipco]['body']));

        if (null !== self::find($properties, 'colr')) {
            return true;
        }

        // nclx: primaries 1 (BT.709), transfer 13 (sRGB), matrix 6 (BT.601), full range.
        $properties[] = ['type' => 'colr', 'body' => 'nclx' . pack('nnn', 1, 13, 6) . "\x80"];
        $props[$ipco]['body'] = self::serialise($properties);

        $primaryItem = self::primaryItem($children[$pitm]['body']);
        $ipmaBody = self::associate($props[$ipma]['body'], $primaryItem, count($properties));

        if (null === $ipmaBody) {
            return false;
        }

        $props[$ipma]['body'] = $ipmaBody;
        $children[$iprp]['body'] = self::serialise($props);

        // Item data lives after meta (in mdat), so every absolute offset shifts by however much meta grew.
        $oldMetaEnd = $meta['offset'] + $meta['size'];
        $delta = strlen(self::serialise([['type' => 'meta', 'body' => $metaHeader . self::serialise($children)]])) - $meta['size'];
        $ilocBody = self::shiftOffsets($children[$iloc]['body'], $delta, $oldMetaEnd);

        if (null === $ilocBody) {
            return false;
        }

        $children[$iloc]['body'] = $ilocBody;
        $top[$metaIndex]['body'] = $metaHeader . self::serialise($children);

        return false !== file_put_contents($file, self::serialise($top));
    }

    /**
     * @return array<int, array{type: string, body: string, offset: int, size: int}>
     */
    private static function parse(string $data, int $offset, int $end): array
    {
        $boxes = [];

        while ($offset + 8 <= $end) {
            $size = unpack('N', substr($data, $offset, 4))[1];
            $header = 8;

            if (1 === $size) {
                $size = unpack('J', substr($data, $offset + 8, 8))[1];
                $header = 16;
            } elseif (0 === $size) {
                $size = $end - $offset;
            }

            if ($size < $header || $offset + $size > $end) {
                break;
            }

            $boxes[] = [
                'type' => substr($data, $offset + 4, 4),
                'body' => substr($data, $offset + $header, $size - $header),
                'offset' => $offset,
                'size' => $size,
            ];

            $offset += $size;
        }

        return $boxes;
    }

    private static function serialise(array $boxes): string
    {
        $out = '';

        foreach ($boxes as $box) {
            $size = 8 + strlen($box['body']);
            $out .= $size > 0xFFFFFFFF
                ? pack('N', 1) . $box['type'] . pack('J', $size + 8) . $box['body']
                : pack('N', $size) . $box['type'] . $box['body'];
        }

        return $out;
    }

    private static function find(array $boxes, string $type): ?int
    {
        foreach ($boxes as $i => $box) {
            if ($box['type'] === $type) {
                return $i;
            }
        }

        return null;
    }

    private static function primaryItem(string $pitm): int
    {
        return 0 === ord($pitm[0]) ? unpack('n', substr($pitm, 4, 2))[1] : unpack('N', substr($pitm, 4, 4))[1];
    }

    /**
     * Adds a (non-essential) association from $itemId to property $propertyIndex in an ipma body.
     */
    private static function associate(string $ipma, int $itemId, int $propertyIndex): ?string
    {
        $version = ord($ipma[0]);
        $wideIndex = (ord($ipma[3]) & 1) === 1;

        if (!$wideIndex && $propertyIndex > 0x7F) {
            return null;
        }

        $offset = 8;
        $count = unpack('N', substr($ipma, 4, 4))[1];

        for ($i = 0; $i < $count; $i++) {
            $id = $version < 1 ? unpack('n', substr($ipma, $offset, 2))[1] : unpack('N', substr($ipma, $offset, 4))[1];
            $offset += $version < 1 ? 2 : 4;
            $associations = ord($ipma[$offset]);
            $entriesEnd = $offset + 1 + $associations * ($wideIndex ? 2 : 1);

            if ($id === $itemId) {
                if ($associations === 0xFF) {
                    return null;
                }

                $entry = $wideIndex ? pack('n', $propertyIndex) : chr($propertyIndex);

                return substr($ipma, 0, $offset) . chr($associations + 1)
                    . substr($ipma, $offset + 1, $entriesEnd - $offset - 1) . $entry . substr($ipma, $entriesEnd);
            }

            $offset = $entriesEnd;
        }

        return null;
    }

    /**
     * Adds $delta to every file offset in an iloc body that points past $after.
     */
    private static function shiftOffsets(string $iloc, int $delta, int $after): ?string
    {
        $version = ord($iloc[0]);
        $offsetSize = ord($iloc[4]) >> 4;
        $lengthSize = ord($iloc[4]) & 0xF;
        $baseSize = ord($iloc[5]) >> 4;
        $indexSize = $version > 0 ? ord($iloc[5]) & 0xF : 0;

        $pos = 6;
        $count = $version < 2 ? self::readInt($iloc, $pos, 2) : self::readInt($iloc, $pos, 4);

        for ($i = 0; $i < $count; $i++) {
            $pos += $version < 2 ? 2 : 4; // item_ID
            $method = 0;

            if ($version > 0) {
                $method = self::readInt($iloc, $pos, 2) & 0xF;
            }

            $pos += 2; // data_reference_index
            $basePos = $pos;
            $base = self::readInt($iloc, $pos, $baseSize);
            $extents = self::readInt($iloc, $pos, 2);

            // Only file offsets (construction method 0) move. idat/item-relative offsets don't.
            $shiftBase = 0 === $method && $baseSize > 0 && $base >= $after;

            if ($shiftBase) {
                self::writeInt($iloc, $basePos, $baseSize, $base + $delta);
            }

            for ($e = 0; $e < $extents; $e++) {
                $pos += $indexSize;
                $extentPos = $pos;
                $extentOffset = self::readInt($iloc, $pos, $offsetSize);
                $pos += $lengthSize;

                if (0 === $method && !$shiftBase && $offsetSize > 0 && $base + $extentOffset >= $after) {
                    self::writeInt($iloc, $extentPos, $offsetSize, $extentOffset + $delta);
                }
            }
        }

        return $pos <= strlen($iloc) ? $iloc : null;
    }

    private static function readInt(string $data, int &$pos, int $size): int
    {
        $value = 0;

        for ($i = 0; $i < $size; $i++) {
            $value = ($value << 8) | ord($data[$pos + $i] ?? "\0");
        }

        $pos += $size;

        return $value;
    }

    private static function writeInt(string &$data, int $pos, int $size, int $value): void
    {
        for ($i = $size - 1; $i >= 0; $i--) {
            $data[$pos + $i] = chr($value & 0xFF);
            $value >>= 8;
        }
    }
}
