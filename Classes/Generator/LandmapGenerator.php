<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Color\MapColorizer;
use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Enum\FillType;
use ChristianEssl\LandmapGeneration\Struct\Map;
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
    protected HeightmapGeneratorInterface $heightmapGenerator;

    protected WaterLevelGeneratorInterface $waterLevelGenerator;

    protected MapColorizer $mapColorizer;

    protected int $width;

    protected int $height;

    public function __construct(
        GeneratorSettingsInterface $settings,
        string $seed,
        HeightmapGeneratorInterface $heightmapGenerator = null,
        WaterLevelGeneratorInterface $waterLevelGenerator = null
    )
    {
        Random::seed($seed);

        if ($heightmapGenerator === null) {
            $heightmapGenerator = new DiamondSquareHeightmapGenerator();
        }
        $this->heightmapGenerator = $heightmapGenerator;
        $this->heightmapGenerator->applySettings($settings);

        if ($waterLevelGenerator === null) {
            $waterLevelGenerator = new WaterLevelGenerator();
        }
        $this->waterLevelGenerator = $waterLevelGenerator;
        $this->waterLevelGenerator->applySettings($settings);

        $this->mapColorizer = new MapColorizer($settings->getColorScheme());
        $this->width = $settings->getWidth();
        $this->height = $settings->getHeight();
    }

    public function generateMap(): Map
    {
        $map = new Map(
            $this->width,
            $this->height
        );
        
        $map->heightmap = $this->heightmapGenerator->createHeightmap($map);
        $waterLevel = $this->waterLevelGenerator->createWaterLevel($map);
        $map->fillTypes = $this->getFillTypes($map, $waterLevel);
        $map->heightmap = $this->adjustAltitudeToWaterLevel($map, $waterLevel);
        $map->colors = $this->mapColorizer->createColors($map);

        return $map;
    }

    /**
     * @return array[]
     */
    protected function getFillTypes(Map $map, float $waterLevel): array
    {
        $fillTypes = [];

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->heightmap[$x][$y];
            $fillType = ($altitude > $waterLevel) ? FillType::LAND->value : FillType::WATER->value;
            $fillTypes[$x][$y] = $fillType;
        }

        return $fillTypes;
    }

    protected function adjustAltitudeToWaterLevel(Map $map, float $waterLevel): array
    {
        $altitudes = [];

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->heightmap[$x][$y];
            $altitude -= $waterLevel; // waterlevel now becomes 0
            $altitude *= 75000; // converted to meters
            $altitudes[$x][$y] = $altitude;
        }

        return $altitudes;
    }
}