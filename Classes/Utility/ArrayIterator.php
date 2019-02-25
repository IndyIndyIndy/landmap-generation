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
     * @param Map $map
     *
     * @return \Generator
     */
    public static function getMapIterator(Map $map): \Generator
    {
        return (function (Map $map) {
            for ($x = 0; $x < $map->width; $x++) {
                for ($y = 0; $y < $map->height; $y++) {
                    yield $x => $y;
                }
            }
        })($map);
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