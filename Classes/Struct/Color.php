<?php

namespace ChristianEssl\LandmapGeneration\Struct;

/**
 * Color representing 32bit rgb values (0 - 255)
 */
class Color
{
    public int $r;
    public int $g;
    public int $b;

    public function __construct(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }
}