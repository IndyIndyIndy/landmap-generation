<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Utility\Random;

class FlatShader implements ShaderInterface
{
    /**
     * @var Color[]
     */
    protected array $shades = [];
    protected int $pixelizeFactor = 10;

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
     * @return Color[]
     */
    public function createShades(Map $map): array
    {
        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->heightmap[$x][$y];

            if ($map->fillTypes[$x][$y] == FillType::LAND->value) {
                $shadeLevel = 1;
                $currentHeight = 1500;

                while ($altitude >= $currentHeight) {
                    $shadeLevel++;
                    $currentHeight += 1500;
                }
                $shade = abs((50 + 20 * $shadeLevel) - 255);
            } else {
                $shade = 255 + (int)Random::getNextPosNegFloat() / $this->pixelizeFactor;
            }

            $this->shades[$x][$y] = $shade;
        }

        return $this->shades;
    }
}