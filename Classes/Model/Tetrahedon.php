<?php
namespace ChristianEssl\LandmapGeneration\Model;

use ChristianEssl\LandmapGeneration\Utility\Random;

/**
 * Tetrahedon
 */
class Tetrahedon
{
    /**
     * @var Vertex
     */
    public $A;

    /**
     * @var Vertex
     */
    public $B;

    /**
     * @var Vertex
     */
    public $C;

    /**
     * @var Vertex
     */
    public $D;

    /**
     * Tetrahedon constructor.
     *
     * @param Vertex $A
     * @param Vertex $B
     * @param Vertex $C
     * @param Vertex $D
     */
    public function __construct($A, $B, $C, $D)
    {
        $this->A = $A;
        $this->B = $B;
        $this->C = $C;
        $this->D = $D;
    }

    /**
     * @param float $altitude
     *
     * @return Tetrahedon
     */
    public static function createRandomForAltitude(float $altitude) : self
    {
        $A = new Vertex(
            self::RandomCoordinate(false),
            self::RandomCoordinate(false),
            self::RandomCoordinate(false),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $B = new Vertex(
            self::RandomCoordinate(false),
            self::RandomCoordinate(true),
            self::RandomCoordinate(true),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $C = new Vertex(
            self::RandomCoordinate(true),
            self::RandomCoordinate(false),
            self::RandomCoordinate(true),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $D = new Vertex(
            self::RandomCoordinate(true),
            self::RandomCoordinate(true),
            self::RandomCoordinate(false),
            $altitude,
            Random::getNextPosNegFloat()
        );
        return new self($A, $B, $C, $D);
    }

    /**
     * @param Tetrahedon $tetrahedon
     *
     * @return Tetrahedon
     */
    public static function copy(Tetrahedon $tetrahedon) : self
    {
        return new self(
            clone $tetrahedon->A,
            clone $tetrahedon->B,
            clone $tetrahedon->C,
            clone $tetrahedon->D
        );
    }

    /**
     * @todo: outsource?
     * @param bool $positive
     *
     * @return float
     */
    protected static function RandomCoordinate(bool $positive) : float
    {
        $mod = ($positive) ? 1.0 : -1.0;
        return sqrt(3.0) * $mod + mt_rand(16, 27) * 0.1 * $mod;
    }

}