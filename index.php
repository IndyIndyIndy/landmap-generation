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
use \ChristianEssl\LandmapGeneration\Generator\AltitudeGenerator;
use \ChristianEssl\LandmapGeneration\Generator\WaterLevelGenerator;

$seed = 'testseed';
$settings = (new MapSettings())
    ->setWidth(150)
    ->setHeight(150)
    ->setWaterLevel(66);

$landmapGenerator = new LandmapGenerator(
    $settings,
    $seed,
    new AltitudeGenerator(),
    new WaterLevelGenerator()
);
$map = $landmapGenerator->generateMap();

\ChristianEssl\LandmapGeneration\Utility\ImageUtility::outputMapToImagePng($map);
