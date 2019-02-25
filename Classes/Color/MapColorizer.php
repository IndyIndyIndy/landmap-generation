<?php

namespace ChristianEssl\LandmapGeneration\Color;
use ChristianEssl\LandmapGeneration\Model\Map;

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
        //@todo
        return [];
    }

}