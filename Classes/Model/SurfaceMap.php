<?php
namespace ChristianEssl\LandmapGeneration\Model;

/**
 * SurfaceMap
 */
class SurfaceMap
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
     * SurfaceMap constructor.
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