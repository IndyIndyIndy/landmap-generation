<?php

namespace ChristianEssl\LandmapGeneration\Color;

/**
 * ColorSchemeInterface
 */
interface ColorSchemeInterface
{

    /**
     * @param int $fillType
     *
     * @return array
     */
    public function getColorForType(int $fillType);

    /**
     * @param int $fillType
     * @param int $shade
     *
     * @return array
     */
    public function getShadedColorForType(int $fillType, int $shade);

}