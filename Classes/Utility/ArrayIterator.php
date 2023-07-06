<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Struct\Map;
use Generator;

/**
 * ArrayIterator
 *
 * Simplifies iterating over two-dimensional arrays using an x/y structure
 */
class ArrayIterator
{
    public static function getMapIterator(Map $map): Generator
    {
        return self::getArrayIterator($map->width, $map->height);
    }

    public static function getArrayIterator(int $width, int $height): Generator
    {
        return (static function (int $width, int $height) {
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    yield $x => $y;
                }
            }
        })($width, $height);
    }
}