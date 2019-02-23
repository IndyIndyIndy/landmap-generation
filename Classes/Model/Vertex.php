<?php
namespace ChristianEssl\LandmapGeneration\Model;

/**
 * Vertex
 */
class Vertex
{
    /**
     * @var float
     */
    public $x;

    /**
     * @var float
     */
    public $y;

    /**
     * @var float
     */
    public $z;

    /**
     * @var float
     */
    public $altitude;

    /**
     * @var string
     */
    public $seed;

    /**
     * Vertex constructor.
     *
     * @param float $x
     * @param float $y
     * @param float $z
     * @param float|null $altitude
     * @param string|null $seed
     */
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