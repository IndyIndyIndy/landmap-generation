<?php

namespace ChristianEssl\LandmapGeneration\Model;

/**
 * Color
 *
 * Color representing 32bit rgb values (0 - 255)
 */
class Color
{
    /**
     * @var int
     */
    public $r;

    /**
     * @var int
     */
    public $g;

    /**
     * @var int
     */
    public $b;

    /**
     * Vertex constructor.
     *
     * @param int $r
     * @param int $g
     * @param int $b
     */
    public function __construct(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }
}