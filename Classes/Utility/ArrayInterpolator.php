<?php

namespace ChristianEssl\LandmapGeneration\Utility;

/**
 * ArrayInterpolator
 *
 * Interpolates empty spaces in the given array by looking at each neighbour and calculating a middle value
 */
class ArrayInterpolator
{
    /**
     * @param array $array
     * @param int $width
     * @param int $height
     *
     * @return array
     */
    public static function interpolate(array $array, int $width, int $height): array
    {
        foreach (ArrayIterator::getArrayIterator()($width, $height) as $x => $y) {
            if (!self::coordinatesExist($array, $x, $y)) {
                $val = self::fillCoordinateFromCorners($array, $width, $height, $x, $y);
                if ($val) {
                    $array[$x][$y] = $val;
                }
            }
        }

        foreach (ArrayIterator::getArrayIterator()($width, $height) as $x => $y) {
            if (!self::coordinatesExist($array, $x, $y)) {
                $val = self::fillCoordinateFromAdjacent($array, $width, $height, $x, $y);
                if ($val) {
                    $array[$x][$y] = $val;
                }
            }
        }
        return $array;
    }

    /**
     * @param array $array
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     *
     * @return float
     */
    protected static function fillCoordinateFromCorners(array $array, int $width, int $height, int $x, int $y): ?float
    {
        $altitudes = 0;
        $count = 0;

        if ($x > 0) {
            if ($y > 0 && self::coordinatesExist($array, $x - 1, $y - 1)) {
                $altitudes += $array[$x - 1][$y - 1];
                $count++;
            }

            if ($y < ($height - 1) && self::coordinatesExist($array, $x - 1, $y + 1)) {
                $altitudes += $array[$x - 1][$y + 1];
                $count++;
            }
        }

        if ($y > 0) {
            if ($x > 0 && self::coordinatesExist($array, $x - 1, $y - 1)) {
                $altitudes += $array[$x - 1][$y - 1];
                $count++;
            }

            if ($x < ($width - 1) && self::coordinatesExist($array, $x + 1, $y - 1)) {
                $altitudes += $array[$x + 1][$y - 1];
                $count++;
            }
        }

        if ($count > 0) {
            return $altitudes / $count;
        }
        return null;
    }

    /**
     * @param array $array
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     *
     * @return float
     */
    protected static function fillCoordinateFromAdjacent(array $array, int $width, int $height, int $x, int $y): ?float
    {
        $altitudes = 0;
        $count = 0;

        if ($x > 0 && self::coordinatesExist($array, $x - 1, $y)) {
            $altitudes += $array[$x - 1][$y];
            $count++;
        }

        if ($x < ($width - 1) && self::coordinatesExist($array, $x + 1, $y)) {
            $altitudes += $array[$x + 1][$y];
            $count++;
        }

        if ($y > 0 && self::coordinatesExist($array, $x, $y - 1)) {
            $altitudes += $array[$x][$y - 1];
            $count++;
        }

        if ($y < ($height - 1) && self::coordinatesExist($array, $x, $y + 1)) {
            $altitudes += $array[$x][$y + 1];
            $count++;
        }

        if ($count > 0) {
            return $altitudes / $count;
        }

        return null;
    }

    /**
     * @param array $array
     * @param int $x
     * @param int $y
     *
     * @return bool
     */
    protected static function coordinatesExist(array $array, int $x, int $y): bool
    {
        return isset($array[$x]) && isset($array[$x][$y]);
    }
}