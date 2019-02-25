<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Model\Map;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * Interface for the AltitudeGenerator, in case an alternative algorithm is needed in the future
 */
interface AltitudeGeneratorInterface
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
    public function createAltitudeMap(Map $map);

}