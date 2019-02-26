<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Color\Shader\ShaderInterface;
use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * ColorSchemeInterface
 */
interface ColorSchemeInterface
{

    /**
     * @param Map $map
     * @param int $x
     * @param int $y
     *
     * @return array
     */
    public function getColor(Map $map, int $x, int $y);

    /**
     * @return ShaderInterface
     */
    public function getShader();

}