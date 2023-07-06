<?php

namespace ChristianEssl\LandmapGeneration\Struct;

/**
 * Vertex
 */
class Vertex
{
    public float $x;
    public float $y;
    public float $z;
    public float $altitude;
    public string $seed;

    public function __construct(float $x, float $y, float $z, ?float $altitude = null, ?string $seed = null)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;

        if ($altitude !== null) {
            $this->altitude = $altitude;
        }

        if ($seed !== null) {
            $this->seed = $seed;
        }
    }
}