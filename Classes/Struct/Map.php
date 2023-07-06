<?php
namespace ChristianEssl\LandmapGeneration\Struct;

class Map
{
    public int $width;
    public int $height;

    /**
     * @var array[]
     */
    public array $heightmap = [];

    /**
     * @var array[]
     */
    public array $fillTypes = [];

    /**
     * @var array[]
     */
    public array $colors = [];

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
}