<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Color\MapColorizer;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Model\Map;
use ChristianEssl\LandmapGeneration\Utility\Random;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * LandmapGenerator
 *
 * Generates a landmap by delegating the actual tasks (altitude generation, water level, colouring, shading, etc.)
 * to specific generators.
 */
class LandmapGenerator
{
    /**
     * @var AltitudeGeneratorInterface
     */
    protected $altitudeGenerator;

    /**
     * @var WaterLevelGeneratorInterface
     */
    protected $waterLevelGenerator;

    /**
     * @var MapColorizer
     */
    protected $mapColorizer;

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
     * @param WaterLevelGeneratorInterface $waterLevelGenerator
     */
    public function __construct(
        GeneratorSettingsInterface $settings,
        string $seed,
        AltitudeGeneratorInterface $altitudeGenerator,
        WaterLevelGeneratorInterface $waterLevelGenerator
    ) {
        Random::seed($seed);

        $this->altitudeGenerator = $altitudeGenerator;
        $this->altitudeGenerator->applySettings($settings);

        $this->waterLevelGenerator = $waterLevelGenerator;
        $this->waterLevelGenerator->applySettings($settings);

        $this->mapColorizer = new MapColorizer($settings->getColorScheme());
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
        $waterLevel = $this->waterLevelGenerator->createWaterLevel($map);
        $map->fillTypes = $this->getFillTypes($map, $waterLevel);
        $map->altitudes = $this->adjustAltitudeToWaterLevel($map, $waterLevel);
        $map->colors = $this->mapColorizer->createColors($map);

        return $map;
    }

    /**
     * @param Map $map
     * @param float $waterLevel
     *
     * @return array
     */
    protected function getFillTypes(Map $map, float $waterLevel): array
    {
        $fillTypes = [];

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];
            $fillType = ($altitude > $waterLevel) ? FillType::LAND : FillType::WATER;
            $fillTypes[$x][$y] = $fillType;
        }

        return $fillTypes;
    }

    /**
     * @param Map $map
     * @param float $waterLevel
     *
     * @return array
     */
    protected function adjustAltitudeToWaterLevel(Map $map, float $waterLevel): array
    {
        $altitudes = [];

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];
            $altitude -= $waterLevel; // waterlevel now becomes 0
            $altitude *= 75000; // converted to meters
            $altitudes[$x][$y] = $altitude;
        }

        return $altitudes;
    }
}