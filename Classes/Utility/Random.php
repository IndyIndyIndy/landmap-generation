<?php

namespace ChristianEssl\LandmapGeneration\Utility;

/**
 * Random
 */
class Random
{

    /**
     * @param string $seed
     */
    public static function seed(string $seed)
    {
        mt_srand(crc32($seed));
    }

    /**
     * Returns a float from 0.0 to 1.0
     *
     * @return float
     */
    public static function getNextFloat(): float
    {
        return mt_rand() / mt_getrandmax();
    }

    /**
     * Returns a float from -1.0 to 1.0
     *
     * @return float
     */
    public static function getNextPosNegFloat(): float
    {
        $rand = self::getNextFloat();
        if (mt_rand(0, 1) === 1) {
            return $rand * -1;
        }
        return $rand;
    }

    /***
     * @param bool $positive
     *
     * @return float
     */
    public static function getRandomCoordinate(bool $positive): float
    {
        $mod = ($positive) ? 1.0 : -1.0;
        return sqrt(3.0) * $mod + mt_rand(16, 27) * 0.1 * $mod;
    }

}