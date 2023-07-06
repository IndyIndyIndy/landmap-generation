<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Utility\Random;

class DetailShader implements ShaderInterface
{
    /**
     * @var Color[]
     */
    protected array $shades = [];
    protected FlatShader $flatShader;

    public function __construct()
    {
        $this->flatShader = new FlatShader();
    }

    public function shadeColor(Color $color, int $x, int $y): Color
    {
        return $this->flatShader->shadeColor($color, $x, $y);
    }

    /**
     * @return Color[]
     */
    public function createShades(Map $map): array
    {
        $this->shades = $this->flatShader->createShades($map);
        list ($lowestLand, $highestLand) = $this->getLowestAndHighestLandAltitude($map);

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            if ($map->fillTypes[$x][$y] == FillType::LAND->value) {
                $altitude = $map->heightmap[$x][$y];
                $this->shades[$x][$y] = (int)((($altitude + abs($lowestLand)) / $highestLand + Random::getNextPosNegFloat() / 10) * 127) + 63;
            }
        }

        return $this->shades;
    }

    /**
     * @return float[]
     */
    protected function getLowestAndHighestLandAltitude(Map $map): array
    {
        $lowestLand = 100;
        $highestLand = 0.0;

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->heightmap[$x][$y];
            if ($altitude > 0 && $map->fillTypes[$x][$y] != FillType::WATER->value) {
                $lowestLand = min($lowestLand, $altitude);
                $highestLand = max($highestLand, $altitude);
            }
        }

        return [$lowestLand, $highestLand];
    }
}