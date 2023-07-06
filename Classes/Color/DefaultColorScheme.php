<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Color\Shader\NullShader;
use ChristianEssl\LandmapGeneration\Color\Shader\ShaderInterface;
use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use InvalidArgumentException;

class DefaultColorScheme implements ColorSchemeInterface
{
    /**
     * @var Color[]
     */
    protected array $colors = [];
    protected ShaderInterface $shader;

    public function __construct(ShaderInterface $shader = null)
    {
        $this->colors[FillType::LAND->value] = new Color(2, 98, 6);
        $this->colors[FillType::WATER->value] = new Color(24, 94, 188);

        if ($shader === null) {
            $shader = new NullShader();
        }
        $this->shader = $shader;
    }

    public function getColor(Map $map, int $x, int $y): Color
    {
        $fillType = $map->fillTypes[$x][$y];

        if (!isset($this->colors[$fillType])) {
            throw new InvalidArgumentException('The specified fillType ' . $fillType . ' does not exist as a color');
        }
        $color = $this->colors[$fillType];
        return $this->shader->shadeColor($color, $x, $y);
    }

    public function getShader(): ShaderInterface
    {
        return $this->shader;
    }
}