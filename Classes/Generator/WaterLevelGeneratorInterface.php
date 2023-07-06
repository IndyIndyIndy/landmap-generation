<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * Interface for the WaterLevelGenerator
 */
interface WaterLevelGeneratorInterface
{
    public function applySettings(GeneratorSettingsInterface $settings): void;

    public function createWaterLevel(Map $map): float;
}