<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Struct\Map;

/**
 * ArrayIterator
 *
 * Simplifies iterating over two dimensional arrays using a x/y structure
 */
class ArrayIterator
{
    /**
     * @param Map $map
     *
     * @return \Generator
     */
    public static function getMapIterator(Map $map): \Generator
    {
        return self::getArrayIterator($map->width, $map->height);
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return \Generator
     */
    public static function getArrayIterator(int $width, int $height): \Generator
    {
        return (function (int $width, int $height) {
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    yield $x => $y;
                }
            }
        })($width, $height);
    }

}