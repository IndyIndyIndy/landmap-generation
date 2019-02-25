<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * ArrayIterator
 *
 * Simplifies iterating over two dimensional arrays using a x/y structure
 */
class ArrayIterator
{
    /**
     * @return \Closure
     */
    public static function getMapIterator(): \Closure
    {
        return function (Map $map) {
            for ($x = 0; $x < $map->width; $x++) {
                for ($y = 0; $y < $map->height; $y++) {
                    yield $x => $y;
                }
            }
        };
    }

    /**
     * @return \Closure
     */
    public static function getArrayIterator(): \Closure
    {
        return function (int $width, int $height) {
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    yield $x => $y;
                }
            }
        };
    }

}