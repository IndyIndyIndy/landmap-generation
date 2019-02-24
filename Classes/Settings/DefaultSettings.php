<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;

/**
 * DefaultSettings
 */
class DefaultSettings implements GeneratorSettingsInterface
{
    /**
     * @var float
     */
    protected $initialWaterLevel = -0.002;

    /**
     * @var float
     */
    protected $altitudeDifferenceWeight = 0.45;

    /**
     * @var float
     */
    protected $distanceDifferenceWeight = 0.035;

    /**
     * @var DefaultColorScheme
     */
    protected $colorScheme;

    /**
     * @var int
     */
    protected $width = 50;

    /**
     * @var int
     */
    protected $height = 50;

    public function __construct()
    {
        $this->colorScheme = new DefaultColorScheme();
    }

    /**
     * Initial (default) water level when generating the map
     *
     * @return float
     */
    public function getInitialWaterLevel(): float
    {
        return $this->initialWaterLevel;
    }

    /**
     * @return float
     */
    public function getAltitudeDifferenceWeight(): float
    {
        return $this->altitudeDifferenceWeight;
    }

    /**
     * @return float
     */
    public function getDistanceDifferenceWeight(): float
    {
        return $this->distanceDifferenceWeight;
    }

    /**
     * @return DefaultColorScheme
     */
    public function getColorScheme(): DefaultColorScheme
    {
        return $this->colorScheme;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

}