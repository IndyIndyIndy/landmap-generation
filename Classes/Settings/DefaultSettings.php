<?php
namespace ChristianEssl\LandmapGeneration\Settings;
use ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;

/**
 * DefaultSettings
 */
class DefaultSettings implements GeneratorSettingsInterface
{
    /**
     * @var float
     */
    protected $initialWaterLevel = -0.002;

    /**
     * @var DefaultColorScheme
     */
    protected $defaultColorScheme;

    /**
     * @var int
     */
    protected $width = 50;

    /**
     * @var int
     */
    protected $height = 50;

    public function __construct()
    {
        $this->defaultColorScheme = new DefaultColorScheme();
    }

    /**
     * Initial (default) water level when generating the map
     *
     * @return float
     */
    public function getInitialWaterLevel() : float
    {
        return $this->initialWaterLevel;
    }

    /**
     * @return DefaultColorScheme
     */
    public function getColorScheme() : DefaultColorScheme
    {
        return $this->defaultColorScheme;
    }

    /**
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

}