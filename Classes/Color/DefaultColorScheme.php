<?php

namespace ChristianEssl\LandmapGeneration\Color;

use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Model\Color;

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
     * DefaultColorScheme constructor.
     */
    public function __construct()
    {
        $this->colors[FillType::LAND] = new Color(2, 98, 6);
        $this->colors[FillType::WATER] = new Color(24, 94, 188);
    }

    /**
     * @param int $fillType
     *
     * @return Color
     */
    public function getColorForType(int $fillType): Color
    {
        if (!isset($this->colors[$fillType])) {
            throw new \InvalidArgumentException('The specified fillType ' . $fillType . ' does not exist as a color');
        }
        return $this->colors[$fillType];
    }

    /**
     * @param int $fillType
     * @param int $shade
     *
     * @return Color
     */
    public function getShadedColorForType(int $fillType, int $shade): Color
    {
        $color = $this->getColorForType($fillType);
        return new Color(
            (int)min($shade * $color->r / 150, 255),
            (int)min($shade * $color->g / 150, 255),
            (int)min($shade * $color->b / 150, 255)
        );
    }

}