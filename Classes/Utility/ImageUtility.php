<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\MapIterator;
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

        foreach (MapIterator::getMapIterator()($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];
            $colorCode = self::getColorForAltitude($imageResource, $altitude);
            imagesetpixel($imageResource, $x, $y, $colorCode);
        }

        return $imageResource;
    }

    /**
     * @param resource $image
     * @param float $altitude
     *
     * @return int
     */
    public static function getColorForAltitude($image, float $altitude): int
    {
        //@todo
        $r = self::floatColorToInt($altitude);
        $g = self::floatColorToInt($altitude);
        $b = self::floatColorToInt($altitude);
        return imagecolorallocate($image, $r, $g, $b);
    }

    /**
     * @param float $color
     *
     * @return int
     */
    public static function floatColorToInt(float $color): int
    {
        return (int)floor($color >= 1.0 ? 255 : $color * 256.0);
    }

}