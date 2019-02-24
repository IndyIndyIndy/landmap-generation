<?php

/*
 * @todo landmass/waterlevel generation
 * @todo different color modes
 * @todo output modes - save to file or direct output
 * @todo basic shaders (enable/disable)
 * @todo remove debugging messages
 * @todo readme/documentation
 */

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);

use \ChristianEssl\LandmapGeneration\Generator\LandmapGenerator;
use \ChristianEssl\LandmapGeneration\Settings\MapSettings;

$seed = 'testseed';
$settings = (new MapSettings())
    ->setWidth(150)
    ->setHeight(150);

$landmapGenerator = new LandmapGenerator($settings, $seed);
$map = $landmapGenerator->generateMap();

\ChristianEssl\LandmapGeneration\Utility\ImageUtility::outputMapToImagePng($map);
//var_dump($map);