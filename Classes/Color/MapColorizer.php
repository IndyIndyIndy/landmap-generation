<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;

class MapColorizer
{
    protected ColorSchemeInterface $colorScheme;

    public function __construct(ColorSchemeInterface $colorScheme)
    {
        $this->colorScheme = $colorScheme;
    }

    /**
     * @return Color[]
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