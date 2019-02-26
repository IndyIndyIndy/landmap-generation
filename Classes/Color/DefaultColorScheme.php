<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Color\Shader\NullShader;
use ChristianEssl\LandmapGeneration\Color\Shader\ShaderInterface;
use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Model\Color;
use ChristianEssl\LandmapGeneration\Model\Map;

/**
 * DefaultColorScheme
 */
class DefaultColorScheme implements ColorSchemeInterface
{
    /**
     * @var Color[]
     */
    protected $colors = [];

    /**
     * @var ShaderInterface
     */
    protected $shader;

    /**
     * DefaultColorScheme constructor.
     *
     * @param ShaderInterface $shader
     */
    public function __construct(ShaderInterface $shader = null)
    {
        $this->colors[FillType::LAND] = new Color(2, 98, 6);
        $this->colors[FillType::WATER] = new Color(24, 94, 188);

        if ($shader === null) {
            $shader = new NullShader();
        }
        $this->shader = $shader;
    }

    /**
     * @param Map $map
     * @param int $x
     * @param int $y
     *
     * @return Color
     */
    public function getColor(Map $map, int $x, int $y): Color
    {
        $fillType = $map->fillTypes[$x][$y];

        if (!isset($this->colors[$fillType])) {
            throw new \InvalidArgumentException('The specified fillType ' . $fillType . ' does not exist as a color');
        }
        $color = $this->colors[$fillType];
        return $this->shader->shadeColor($color, $x, $y);
    }

    /**
     * @return ShaderInterface
     */
    public function getShader(): ShaderInterface
    {
        return $this->shader;
    }

}