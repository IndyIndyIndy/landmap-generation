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
    public static function createRandomForAltitude(float $altitude): self
    {
        $A = new Vertex(
            Random::getRandomCoordinate(false),
            Random::getRandomCoordinate(false),
            Random::getRandomCoordinate(false),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $B = new Vertex(
            Random::getRandomCoordinate(false),
            Random::getRandomCoordinate(true),
            Random::getRandomCoordinate(true),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $C = new Vertex(
            Random::getRandomCoordinate(true),
            Random::getRandomCoordinate(false),
            Random::getRandomCoordinate(true),
            $altitude,
            Random::getNextPosNegFloat()
        );
        $D = new Vertex(
            Random::getRandomCoordinate(true),
            Random::getRandomCoordinate(true),
            Random::getRandomCoordinate(false),
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
    public static function copy(Tetrahedon $tetrahedon): self
    {
        return new self(
            clone $tetrahedon->A,
            clone $tetrahedon->B,
            clone $tetrahedon->C,
            clone $tetrahedon->D
        );
    }

}