<?php

namespace ChristianEssl\LandmapGeneration\Settings;

use ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;
use OutOfBoundsException;

class MapSettings extends DefaultSettings
{
    public function setInitialWaterLevel(float $initialWaterLevel): self
    {
        $this->initialWaterLevel = $initialWaterLevel;
        return $this;
    }

    public function setAltitudeDifferenceWeight(float $altitudeDifferenceWeight): self
    {
        $this->altitudeDifferenceWeight = $altitudeDifferenceWeight;
        return $this;
    }

    public function setDistanceDifferenceWeight(float $distanceDifferenceWeight): self
    {
        $this->distanceDifferenceWeight = $distanceDifferenceWeight;
        return $this;
    }

    public function setColorScheme(DefaultColorScheme $colorScheme): self
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }

    public function setWidth(int $width): self
    {
        if ($width < 1) {
            throw new OutOfBoundsException('Width has to be above 0');
        }
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height): self
    {
        if ($height < 1) {
            throw new OutOfBoundsException('Height has to be above 0');
        }
        $this->height = $height;
        return $this;
    }

    public function setInterpolationMode(bool $interpolationMode): self
    {
        $this->interpolationMode = $interpolationMode;
        return $this;
    }

    public function setWaterLevel(float $waterLevel): self
    {
        if ($waterLevel < 0 || $waterLevel > 100) {
            throw new OutOfBoundsException('Water level has to be in 0 - 100% range');
        }
        $this->waterLevel = $waterLevel;
        return $this;
    }
}