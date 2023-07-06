<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;

class NullShader implements ShaderInterface
{
    public function shadeColor(Color $color, int $x, int $y): Color
    {
        return $color;
    }

    public function createShades(Map $map): array
    {
        return [];
    }
}