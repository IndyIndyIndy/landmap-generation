<?php

namespace ChristianEssl\LandmapGeneration;

use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * MapIterator
 */
class MapIterator
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

}