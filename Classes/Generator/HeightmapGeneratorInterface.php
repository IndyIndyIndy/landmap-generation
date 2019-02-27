<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * Interface for the HeightmapGenerator, in case an alternative algorithm is needed in the future
 */
interface HeightmapGeneratorInterface
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
     * @return array
     */
    public function createHeightmap(Map $map);

}