<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * ImageUtility
 */
class ImageUtility
{
    /**
     * @param Map $map
     */
    public static function outputMapToImagePng(Map $map): void
    {
        $image = self::createImage($map);
        header('Content-Type: image/png');
        imagepng($image);
        exit;
    }

    /**
     * @param Map $map
     *
     * @return resource
     */
    protected static function createImage(Map $map)
    {
        $width = $map->width;
        $height = $map->height;
        $imageResource = imagecreatetruecolor($width, $height);

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $color = $map->colors[$x][$y];
            $allocatedColor = self::allocateColor($imageResource, $color);
            imagesetpixel($imageResource, $x, $y, $allocatedColor);
        }

        return $imageResource;
    }

    /**
     * @param resource $image
     * @param array $color
     *
     * @return int
     */
    protected static function allocateColor($image, array $color): int
    {
        return imagecolorallocate($image, $color[0], $color[1], $color[2]);
    }

}