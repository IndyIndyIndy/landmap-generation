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
     *
     * @var float
     */
    protected $initialWaterLevel;

    /**
     * The desired percentage of the map to be covered in water
     *
     * @var float
     */
    protected $desiredWaterLevelPercent;

    /**
     * The allowed imprecision in determining the water level
     * In this example the water percentage can be +- 0.5% off from the desired water level
     *
     * @var float
     */
    protected $allowedImprecision = 0.5;

    /**
     * Search pointer for the boolean search to efficiently calculate the rising/lowering of the water
     *
     * @var float
     */
    protected $searchPointer = 0.1;

    /**
     * @param GeneratorSettingsInterface $settings
     */
    public function applySettings(GeneratorSettingsInterface $settings)
    {
        $this->initialWaterLevel = $settings->getInitialWaterLevel();
        $this->desiredWaterLevelPercent = $settings->getWaterLevel();
    }

    /**
     * @param Map $map
     *
     * @return float
     */
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

    /**
     * @param float $landPercent
     * @param float $expectedLandPercent
     *
     * @return bool
     */
    protected function landLevelDoesNotMatchExpectation(float $landPercent, float $expectedLandPercent): bool
    {
        return (
            $landPercent > $expectedLandPercent + $this->allowedImprecision ||
            $landPercent < $expectedLandPercent - $this->allowedImprecision
        );
    }

    /**
     * Changes the water level by doing a binary search up or down
     *
     * @param float $landPercent
     * @param float $expectedLandPercent
     *
     * @return float
     */
    protected function changeWaterLevel($landPercent, $expectedLandPercent): float
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
     *
     * @param Map $map
     * @param float $waterLevel
     *
     * @return float
     */
    protected function getCurrentLandPercent(Map $map, float $waterLevel): float
    {
        $totalFill = 0;
        $landFill = 0;

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $altitude = $map->altitudes[$x][$y];

            if ($altitude > $waterLevel) {
                $landFill++;
            }

            $totalFill++;
        }
        return $landFill / $totalFill * 100.0;
    }

}