<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Color\Shader\ShaderInterface;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;

interface ColorSchemeInterface
{
    public function getColor(Map $map, int $x, int $y): Color;

    public function getShader(): ShaderInterface;
}