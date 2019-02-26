<?php
namespace ChristianEssl\LandmapGeneration\Struct;

/**
 * Map
 */
class Map
{
    /**
     * @var int
     */
    public $width;

    /**
     * @var int
     */
    public $height;

    /**
     * @var array
     */
    public $altitudes = [];

    /**
     * @var array
     */
    public $fillTypes = [];

    /**
     * @var array
     */
    public $colors = [];

    /**
     * Map constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

}