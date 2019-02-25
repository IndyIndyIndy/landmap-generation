<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Model\Map;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * Interface for the WaterLevelGenerator
 */
interface WaterLevelGeneratorInterface
{
    /**
     * @param GeneratorSettingsInterface $settings
     *
     * @return array
     */
    public function applySettings(GeneratorSettingsInterface $settings);

    /**
     * @param Map $map
     *
     * @return float
     */
    public function createWaterLevel(Map $map);

}