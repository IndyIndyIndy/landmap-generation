<?php

/*
 * @todo output modes - save to file or direct output
 * @todo readme/documentation
 * @todo variables for water level float (in altitude) and water level percentage are currently called the same -> confusing
 * @todo refactor models
 */

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1); //@todo remove this

use \ChristianEssl\LandmapGeneration\Generator\LandmapGenerator;
use \ChristianEssl\LandmapGeneration\Settings\MapSettings;
use \ChristianEssl\LandmapGeneration\Generator\AltitudeGenerator;
use \ChristianEssl\LandmapGeneration\Generator\WaterLevelGenerator;
use \ChristianEssl\LandmapGeneration\Color\DefaultColorScheme;
use \ChristianEssl\LandmapGeneration\Color\Shader\DetailShader;
use \ChristianEssl\LandmapGeneration\Color\Shader\FlatShader;

$seed = 'testseed';
$settings = (new MapSettings())
    ->setColorScheme(new DefaultColorScheme(new FlatShader()))
    ->setWidth(150)
    ->setHeight(150)
    ->setWaterLevel(66.5);

$landmapGenerator = new LandmapGenerator(
    $settings,
    $seed,
    new AltitudeGenerator(),
    new WaterLevelGenerator()
);
$map = $landmapGenerator->generateMap();

\ChristianEssl\LandmapGeneration\Utility\ImageUtility::outputMapToImagePng($map);
