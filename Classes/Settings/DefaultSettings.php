<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;

class DefaultSettings implements GeneratorSettingsInterface
{
    protected float $initialWaterLevel = -0.002;
    protected float $altitudeDifferenceWeight = 0.45;
    protected float $distanceDifferenceWeight = 0.035;
    protected DefaultColorScheme $colorScheme;
    protected int $width = 150;
    protected int $height = 150;
    protected bool $interpolationMode = true;
    protected float $waterLevel = 70.0;

    public function __construct()
    {
        $this->colorScheme = new DefaultColorScheme();
    }

    /**
     * Initial (default) water level when generating the map
     */
    public function getInitialWaterLevel(): float
    {
        return $this->initialWaterLevel;
    }

    public function getAltitudeDifferenceWeight(): float
    {
        return $this->altitudeDifferenceWeight;
    }

    public function getDistanceDifferenceWeight(): float
    {
        return $this->distanceDifferenceWeight;
    }

    public function getColorScheme(): DefaultColorScheme
    {
        return $this->colorScheme;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function isInterpolationMode(): bool
    {
        return $this->interpolationMode;
    }

    public function getWaterLevel(): float
    {
        return $this->waterLevel;
    }
}