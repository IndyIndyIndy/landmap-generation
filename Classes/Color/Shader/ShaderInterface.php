<?php

namespace ChristianEssl\LandmapGeneration\Color\Shader;

use ChristianEssl\LandmapGeneration\Model\Color;
use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * ShaderInterface
 */
interface ShaderInterface
{
    /**
     * @param Color $color
     * @param int $x
     * @param int $y
     *
     * @return Color
     */
    public function shadeColor(Color $color, int $x, int $y);

    /**
     * @param Map $map
     *
     * @return void
     */
    public function createShades(Map $map);

}