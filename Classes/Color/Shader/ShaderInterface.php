<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;

interface ShaderInterface
{
    public function shadeColor(Color $color, int $x, int $y): Color;

    public function createShades(Map $map): array;
}