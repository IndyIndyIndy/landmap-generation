<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Utility\ArrayIterator;
use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;

/**
 * WaterLevelGenerator
 *
 * This implementation simply defines an initial water level,
 * takes the desired waterLevel percent and shifts the water level
 * up/down until the desired percentage of the altitude Map is covered in water.
 */
class WaterLevelGenerator implements WaterLevelGeneratorInterface
{
    /**
     * The initial water level to start from (before we rise or lower it)
     */
    protected float $initialWaterLevel;

    /**
     * The desired percentage of the map to be covered in water
     */
    protected float $desiredWaterLevelPercent;

    /**
     * The allowed imprecision in determining the water level
     * In this example the water percentage can be +- 0.5% off from the desired water level
     */
    protected float $allowedImprecision = 0.5;

    /**
     * Search pointer for the boolean search to efficiently calculate the rising/lowering of the water
     */
    protected float $searchPointer = 0.1;

    public function applySettings(GeneratorSettingsInterface $settings): void
    {
        $this->initialWaterLevel = $settings->getInitialWaterLevel();
        $this->desiredWaterLevelPercent = $settings->getWaterLevel();
    }

    public function createWaterLevel(Map $map): float
    {
        $waterLevel = $this->initialWaterLevel;
        $expectedLandPercent = 100.0 - $this->desiredWaterLevelPercent;
        $landPercent = $this->getCurrentLandPercent($map, $waterLevel);

        // raise/lower water level until we get the desired land / water ratio
        while ($this->landLevelDoesNotMatchExpectation($landPercent, $expectedLandPercent)) {
            $waterLevel += $this->changeWaterLevel($landPercent, $expectedLandPercent);
            $landPercent = $this->getCurrentLandPercent($map, $waterLevel);
        }

        return $waterLevel;
    }

    protected function landLevelDoesNotMatchExpectation(float $landPercent, float $expectedLandPercent): bool
    {
        return (
            $landPercent > $expectedLandPercent + $this->allowedImprecision ||
            $landPercent < $expectedLandPercent - $this->allowedImprecision
        );
    }

    /**
     * Changes the water level by doing a binary search up or down
     */
    protected function changeWaterLevel(float $landPercent, float $expectedLandPercent): float
    {
        if ($landPercent > $expectedLandPercent) {
            $waterLevelDiff = $this->searchPointer;
        } else {
            $waterLevelDiff = -$this->searchPointer;
        }
        $this->searchPointer /= 2;

        return $waterLevelDiff;
    }

    /**
     * Find out how much percentage of the map is currently covered with land
     */
    protected function getCurrentLandPercent(Map $map, float $waterLevel): float
    {
        $totalFill = 0;
        $landFill = 0;

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->heightmap[$x][$y];

            if ($altitude > $waterLevel) {
                $landFill++;
            }

            $totalFill++;
        }

        return $landFill / $totalFill * 100.0;
    }

}