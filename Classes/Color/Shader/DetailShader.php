<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Utility\Random;

/**
 * DetailShader
 */
class DetailShader implements ShaderInterface
{
    /**
     * @var array
     */
    protected $shades = [];

    /**
     * @var FlatShader
     */
    protected $flatShader;

    /**
     * DetailShader constructor.
     */
    public function __construct()
    {
        $this->flatShader = new FlatShader();
    }

    /**
     * @param Color $color
     * @param int $x
     * @param int $y
     *
     * @return Color
     */
    public function shadeColor(Color $color, int $x, int $y): Color
    {
        $shade = $this->shades[$x][$y];
        return new Color(
            (int)min($shade * $color->r / 150, 255),
            (int)min($shade * $color->g / 150, 255),
            (int)min($shade * $color->b / 150, 255)
        );
    }

    /**
     * @param Map $map
     */
    public function createShades(Map $map): void
    {
        $this->shades = $this->flatShader->createShades($map);
        list ($lowestLand, $highestLand) = $this->getLowestAndHighestLandAltitude($map);

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            if ($map->fillTypes[$x][$y] == FillType::LAND) {
                $altitude = $map->altitudes[$x][$y];
                $this->shades[$x][$y] = (int)((($altitude + abs($lowestLand)) / $highestLand + Random::getNextPosNegFloat() / 10) * 127) + 63;
            }
        }
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