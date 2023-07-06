<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\ColorSchemeInterface;

interface GeneratorSettingsInterface
{
    /**
     * Initial (default) water level when generating the map
     */
    public function getInitialWaterLevel(): float;

    /**
     * Initial (default) altitude diff weight for generating the altitude
     */
    public function getAltitudeDifferenceWeight(): float;

    /**
     * Initial (default) distance diff weight for generating the altitude
     */
    public function getDistanceDifferenceWeight(): float;

    /**
     * The used color scheme
     */
    public function getColorScheme(): ColorSchemeInterface;

    /**
     * Map width
     */
    public function getWidth(): int;

    /**
     * Map height
     */
    public function getHeight(): int;

    /**
     * Interpolation mode for performance
     * (only a quarter of altitudes is calculated altitude and the empty neighbours get interpolated)
     */
    public function isInterpolationMode(): bool;

    /**
     * The water level from 0 - 100%
     */
    public function getWaterLevel(): float;
}