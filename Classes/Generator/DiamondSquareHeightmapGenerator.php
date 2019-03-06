<?php

namespace ChristianEssl\LandmapGeneration\Generator;

use ChristianEssl\LandmapGeneration\Struct\Map;
use ChristianEssl\LandmapGeneration\Struct\Tetrahedon;
use ChristianEssl\LandmapGeneration\Struct\Vertex;
use ChristianEssl\LandmapGeneration\Settings\GeneratorSettingsInterface;
use ChristianEssl\LandmapGeneration\Utility\ArrayInterpolator;

/**
 * DiamondSquareHeightmapGenerator
 *
 * This is a PHP implementation of a "diamond-square" algorithm for creating authentic altitude maps.
 * As this is very CPU intensive, by default, an interpolation mode is enabled, which calculates only a
 * quarter of the maps pixels and generates the missing pixels by looking at its neighbours.
 */
class DiamondSquareHeightmapGenerator implements HeightmapGeneratorInterface
{
    const PI = 3.14159265358979;

    /**
     * @var Tetrahedon
     */
    protected $baseTetrahedon;

    /**
     * @var int
     */
    protected $subdivisions;

    /**
     * @var Vertex
     */
    protected $P;

    /**
     * @var float
     */
    protected $altitudeDifferenceWeight;

    /**
     * @var float
     */
    protected $distanceDifferenceWeight;

    /**
     * @var bool
     */
    protected $interpolateAltitudes;

    /**
     * @param GeneratorSettingsInterface $settings
     */
    public function applySettings(GeneratorSettingsInterface $settings)
    {
        $this->baseTetrahedon = Tetrahedon::createRandomForAltitude(
            $settings->getInitialWaterLevel()
        );
        $this->altitudeDifferenceWeight = $settings->getAltitudeDifferenceWeight();
        $this->distanceDifferenceWeight = $settings->getDistanceDifferenceWeight();
        $this->interpolateAltitudes = $settings->isInterpolationMode();
    }

    /**
     * @param Map $map
     *
     * @return array
     */
    public function createHeightmap(Map $map): array
    {
        $width = $map->width;
        $height = $map->height;
        $altitudes = [];

        $this->subdivisions = 3 * (int)(log($height) / log(2.0)) + 3;

        for ($y = 0; $y < $height; $y++) {
            $Py = exp(2.0 * self::PI * (2.0 * $y - $height) / $width);
            $Py = ($Py - 1.0) / ($Py + 1.0);

            for ($x = 0; $x < $width; $x++) {
                $vertex = 0.5 * self::PI + self::PI * (2.0 * $x - $width) / $width;
                $this->P = new Vertex(
                    cos($vertex) * sqrt(1.0 - $Py * $Py),
                    $Py,
                    -sin($vertex) * sqrt(1.0 - $Py * $Py)
                );

                if (!$this->interpolateAltitudes || $x % 2 == 0 && $y % 2 == 0) {
                    $altitudes[$x][$y] = $this->getAltitude();
                }
            }
        }

        if ($this->interpolateAltitudes) {
            $altitudes = ArrayInterpolator::interpolate($altitudes, $width, $height);
        }

        return $altitudes;
    }

    /**
     * @return float
     */
    protected function getAltitude(): float
    {
        return $this->createAltitude(
            Tetrahedon::copy($this->baseTetrahedon),
            $this->subdivisions,
            $this->getEdge($this->baseTetrahedon->A, $this->baseTetrahedon->B)
        );
    }

    /**
     * @param Tetrahedon $tetraRef
     * @param int $level
     * @param float $abEdge
     *
     * @return float
     */
    protected function createAltitude(Tetrahedon $tetraRef, int $level, float $abEdge): float
    {
        $newEdge = null;
        $A = $tetraRef->A;
        $B = $tetraRef->B;
        $C = $tetraRef->C;
        $D = $tetraRef->D;

        if ($level === 0) {
            return ($A->altitude + $B->altitude + $C->altitude + $D->altitude) / 4;
        }

        // order vertices until AB has the longest edge
        foreach ($tetraRef->getVerticeChecks() as $check) {
            $newEdge = $this->getEdge($check[0], $check[1]);
            if ($abEdge < $newEdge) {
                return $this->createAltitude(
                    new Tetrahedon($check[0], $check[1], $check[2], $check[3]),
                    $level,
                    $newEdge
                );
            }
        }

        $E = $this->cutVertex($abEdge, $A, $B);

        if ($this->findPoint($A, $E, $C, $D) > 0) {
            return $this->createAltitude(new Tetrahedon($C, $D, $A, $E), $level - 1, $newEdge);
        }
        return $this->createAltitude(new Tetrahedon($C, $D, $B, $E), $level - 1, $newEdge);
    }

    /**
     * @param float $abEdge
     * @param Vertex $A
     * @param Vertex $B
     *
     * @return Vertex
     */
    protected function cutVertex(float $abEdge, Vertex $A, Vertex $B): Vertex
    {
        $seed = $this->seedOfSeeds($A->seed, $B->seed);
        $seed1 = $this->seedOfSeeds($seed, $seed);
        $seed2 = 0.5 + 0.1 * $this->seedOfSeeds($seed1, $seed1);  /* find cut point */
        $seed3 = 1.0 - $seed2;

        if ($abEdge > 1.0) {
            $abEdge = sqrt($abEdge);
        }

        $altitudeDiff = $seed * $this->altitudeDifferenceWeight * abs($A->altitude - $B->altitude);
        $altitude = ($A->altitude + $B->altitude) / 2 + $altitudeDiff + $seed1 *
            $this->distanceDifferenceWeight * pow($abEdge, 0.47);

        if ($A->seed < $B->seed) {
            return new Vertex(
                $seed2 * $A->x + $seed3 * $B->x,
                $seed2 * $A->y + $seed3 * $B->y,
                $seed2 * $A->z + $seed3 * $B->z,
                $altitude,
                $seed
            );
        } else {
            return new Vertex(
                $seed3 * $A->x + $seed2 * $B->x,
                $seed3 * $A->y + $seed2 * $B->y,
                $seed3 * $A->z + $seed2 * $B->z,
                $altitude,
                $seed
            );
        }
    }

    /**
     * @param Vertex $from
     * @param Vertex $to
     *
     * @return float
     */
    protected function getEdge(Vertex $from, Vertex $to): float
    {
        return ($from->x - $to->x) * ($from->x - $to->x) +
            ($from->y - $to->y) * ($from->y - $to->y) +
            ($from->z - $to->z) * ($from->z - $to->z);
    }

    /**
     * @param Vertex $A
     * @param Vertex $B
     * @param Vertex $C
     * @param Vertex $D
     * @param bool $negate1
     *
     * @return float
     */
    protected function findPoint(Vertex $A, Vertex $B, Vertex $C, Vertex $D, bool $negate1 = false): float
    {
        $mod1 = ($negate1) ? -1.0 : 1.0;

        return (
                $mod1 * ($A->x - $B->x) * ($C->y - $B->y) * ($D->z - $B->z) +
                $mod1 * ($A->y - $B->y) * ($C->z - $B->z) * ($D->x - $B->x) +
                $mod1 * ($A->z - $B->z) * ($C->x - $B->x) * ($D->y - $B->y) -
                $mod1 * ($A->z - $B->z) * ($C->y - $B->y) * ($D->x - $B->x) -
                $mod1 * ($A->y - $B->y) * ($C->x - $B->x) * ($D->z - $B->z) -
                $mod1 * ($A->x - $B->x) * ($C->z - $B->z) * ($D->y - $B->y)
            )
            *
            (
                ($this->P->x - $B->x) * ($C->y - $B->y) * ($D->z - $B->z) +
                ($this->P->y - $B->y) * ($C->z - $B->z) * ($D->x - $B->x) +
                ($this->P->z - $B->z) * ($C->x - $B->x) * ($D->y - $B->y) -
                ($this->P->z - $B->z) * ($C->y - $B->y) * ($D->x - $B->x) -
                ($this->P->y - $B->y) * ($C->x - $B->x) * ($D->z - $B->z) -
                ($this->P->x - $B->x) * ($C->z - $B->z) * ($D->y - $B->y)
            );
    }

    /**
     * @param float $seed1
     * @param float $seed2
     *
     * @return float
     */
    protected function seedOfSeeds(float $seed1, float $seed2): float
    {
        $r = ($seed1 + self::PI) * ($seed2 + self::PI);
        return (float)(2 * ($r - (int)$r) - 1);
    }

}