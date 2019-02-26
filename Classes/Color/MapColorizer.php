<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Enum\ShadingMode;
use ChristianEssl\LandmapGeneration\Model\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Utility\Random;

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
     * @var bool
     */
    protected $useShading = true; // @todo, configurable

    /**
     * @var int
     */
    protected $shadingMode = ShadingMode::FLAT; // @todo, configurable

    /**
     * @var int
     */
    protected $pixelizeFactor = 10; // @todo, configurable

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
        $shades = ($this->useShading) ? $this->getShadesForAltitude($map) : null;
        $colors = [];

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $fillType = $map->fillTypes[$x][$y];

            if ($this->useShading) {
                $shade = $shades[$x][$y];
                $colors[$x][$y] = $this->colorScheme->getShadedColorForType($fillType, $shade);
            } else {
                $colors[$x][$y] = $this->colorScheme->getColorForType($fillType);
            }
        }

        return $colors;
    }

    /**
     * @param Map $map
     *
     * @return array
     */
    protected function getShadesForAltitude(Map $map): array
    {
        $shades = [];

        if ($this->shadingMode === ShadingMode::DETAIL) {
            list ($lowestLand, $highestLand) = $this->getLowestAndHighestLandAltitude($map);
        }

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];

            if ($map->fillTypes[$x][$y] == FillType::LAND) {
                $shadeLevel = 1;
                $currentHeight = 1500;

                while ($altitude >= $currentHeight) {
                    $shadeLevel++;
                    $currentHeight += 1500;
                }
                $shade = abs((50 + 20 * $shadeLevel) - 255);

                if ($this->shadingMode === ShadingMode::DETAIL) { // @todo refactor all this
                    $shade = (int)((($altitude + abs($lowestLand)) / $highestLand + Random::getNextPosNegFloat() / $this->pixelizeFactor) * 127) + 63;
                }
            } else {
                $shade = 255 + (int)Random::getNextPosNegFloat() / $this->pixelizeFactor;
            }

            $shades[$x][$y] = $shade;
        }

        return $shades;
    }

    /**
     * @param Map $map
     *
     * @return array
     */
    protected function getLowestAndHighestLandAltitude(Map $map): array
    {
        $lowestLand = 100;
        $highestLand = 0.0;

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];
            if ($altitude > 0 && $map->fillTypes[$x][$y] != FillType::WATER) {
                $lowestLand = min($lowestLand, $altitude);
                $highestLand = max($highestLand, $altitude);
            }
        }

        return [$lowestLand, $highestLand];
    }
}