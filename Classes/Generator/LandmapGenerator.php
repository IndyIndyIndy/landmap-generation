<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Color\ColorSchemeInterface;
use ChristianEssl\LandmapGeneration\Model\Map;
use ChristianEssl\LandmapGeneration\Utility\Random;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * LandmapGenerator
 */
class LandmapGenerator
{
    /**
     * @var AltitudeGenerator
     */
    protected $altitudeGenerator;

    /**
     * @var ColorSchemeInterface
     */
    protected $colorScheme;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * LandmapGenerator constructor.
     *
     * @param GeneratorSettingsInterface $settings
     * @param string $seed
     * @param AltitudeGeneratorInterface $altitudeGenerator
     */
    public function __construct(
        GeneratorSettingsInterface $settings,
        string $seed,
        AltitudeGeneratorInterface $altitudeGenerator
    ) {
        Random::seed($seed);

        $this->altitudeGenerator = $altitudeGenerator;
        $this->altitudeGenerator->applySettings($settings);
        $this->colorScheme = $settings->getColorScheme();
        $this->width = $settings->getWidth();
        $this->height = $settings->getHeight();
    }

    /**
     * @return Map
     */
    public function generateMap(): Map
    {
        $map = new Map(
            $this->width,
            $this->height
        );
        $map->altitudes = $this->altitudeGenerator->createAltitudeMap($map);
        return $map;
    }

}