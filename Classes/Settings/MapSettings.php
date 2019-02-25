<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;

/**
 * MapSettings
 */
class MapSettings extends DefaultSettings
{
    /**
     * @param float $initialWaterLevel
     *
     * @return MapSettings
     */
    public function setInitialWaterLevel(float $initialWaterLevel): self
    {
        $this->initialWaterLevel = $initialWaterLevel;
        return $this;
    }

    /**
     * @param float $altitudeDifferenceWeight
     *
     * @return MapSettings
     */
    public function setAltitudeDifferenceWeight(float $altitudeDifferenceWeight): self
    {
        $this->altitudeDifferenceWeight = $altitudeDifferenceWeight;
        return $this;
    }

    /**
     * @param float $distanceDifferenceWeight
     *
     * @return MapSettings
     */
    public function setDistanceDifferenceWeight(float $distanceDifferenceWeight): self
    {
        $this->distanceDifferenceWeight = $distanceDifferenceWeight;
        return $this;
    }

    /**
     * @param DefaultColorScheme $colorScheme
     *
     * @return MapSettings
     */
    public function setColorScheme(DefaultColorScheme $colorScheme): self
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }

    /**
     * @param int $width
     *
     * @return MapSettings
     */
    public function setWidth(int $width): self
    {
        if ($width < 1) {
            throw new \OutOfBoundsException('Width has to be above 0');
        }
        $this->width = $width;
        return $this;
    }

    /**
     * @param int $height
     *
     * @return MapSettings
     */
    public function setHeight(int $height): self
    {
        if ($height < 1) {
            throw new \OutOfBoundsException('Height has to be above 0');
        }
        $this->height = $height;
        return $this;
    }

    /**
     * @param bool $interpolationMode
     *
     * @return MapSettings
     */
    public function setInterpolationMode(bool $interpolationMode): self
    {
        $this->interpolationMode = $interpolationMode;
        return $this;
    }

    /**
     * @param float $waterLevel
     *
     * @return MapSettings
     * @throws \OutOfBoundsException
     */
    public function setWaterLevel(float $waterLevel): self
    {
        if ($waterLevel < 0 || $waterLevel > 100) {
            throw new \OutOfBoundsException('Water level has to be in 0 - 100% range');
        }
        $this->waterLevel = $waterLevel;
        return $this;
    }

}