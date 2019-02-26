<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Enum\FillType;

/**
 * DefaultColorScheme
 */
class DefaultColorScheme implements ColorSchemeInterface
{

    /**
     * @var array
     */
    protected $colors = [];

    /**
     * DefaultColorScheme constructor.
     */
    public function __construct()
    {
        $this->colors[FillType::LAND] = [2, 98, 6];
        $this->colors[FillType::WATER] = [24, 94, 188];
    }

    /**
     * @param int $fillType
     *
     * @return array
     */
    public function getColorForType(int $fillType)
    {
        if (!isset($this->colors[$fillType])) {
            throw new \InvalidArgumentException('The specified fillType '.$fillType.' does not exist as a color');
        }
        return $this->colors[$fillType];
    }

    /**
     * @param int $fillType
     * @param int $shade
     *
     * @return array
     */
    public function getShadedColorForType(int $fillType, int $shade)
    {
        $color = $this->getColorForType($fillType);
        return [
            (int) min($shade * $color[0] / 150, 255),
            (int) min($shade * $color[1] / 150, 255),
            (int) min($shade * $color[2] / 150, 255),
        ];
    }

}