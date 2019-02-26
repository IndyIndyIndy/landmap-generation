<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;

/**
 * MapColorizer
 */
class MapColorizer
{
    /**
     * @var ColorSchemeInterface
     */
    protected $colorScheme;

    /**
     * MapColorizer constructor.
     *
     * @param ColorSchemeInterface $colorScheme
     */
    public function __construct(ColorSchemeInterface $colorScheme)
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * @param Map $map
     *
     * @return array
     */
    public function createColors(Map $map): array
    {
        $colors = [];
        $this->colorScheme->getShader()->createShades($map);

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $colors[$x][$y] = $this->colorScheme->getColor($map, $x, $y);
        }

        return $colors;
    }

}