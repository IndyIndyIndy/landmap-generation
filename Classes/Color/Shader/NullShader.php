<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Model\Color;
use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * NullShader
 */
class NullShader implements ShaderInterface
{
    /**
     * @param Color $color
     * @param int $x
     * @param int $y
     *
     * @return Color
     */
    public function shadeColor(Color $color, int $x, int $y): Color
    {
        return $color;
    }

    /**
     * @param Map $map
     */
    public function createShades(Map $map): void
    {

    }

}