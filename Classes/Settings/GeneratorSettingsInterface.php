<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\ColorSchemeInterface;

/**
 * GeneratorSettingsInterface
 */
interface GeneratorSettingsInterface
{

    /**
     * Initial (default) water level when generating the map
     *
     * @return float
     */
    public function getInitialWaterLevel();

    /**
     * Initial (default) altitude diff weight for generating the altitude
     *
     * @return float
     */
    public function getAltitudeDifferenceWeight();

    /**
     * Initial (default) distance diff weight for generating the altitude
     *
     * @return float
     */
    public function getDistanceDifferenceWeight();

    /**
     * The used color scheme
     *
     * @return ColorSchemeInterface
     */
    public function getColorScheme();

    /**
     * Map width
     *
     * @return int
     */
    public function getWidth();

    /**
     * Map height
     *
     * @return int
     */
    public function getHeight();

}