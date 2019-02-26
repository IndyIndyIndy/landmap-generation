<?php

/*
 * @todo readme/documentation
 * @todo variables for water level float (in altitude) and water level percentage are currently called the same -> confusing
 */

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1); //@todo remove this

use ChristianEssl\LandmapGeneration\Settings as Settings;
use ChristianEssl\LandmapGeneration\Generator as Generator;
use ChristianEssl\LandmapGeneration\Color as Color;
use ChristianEssl\LandmapGeneration\Color\Shader as Shader;
use ChristianEssl\LandmapGeneration\Enum as Enum;
use ChristianEssl\LandmapGeneration\Utility as Utility;

$seed = 'testseed';
$settings = (new Settings\MapSettings())
    ->setColorScheme(new Color\DefaultColorScheme(new Shader\FlatShader()))
    ->setWidth(150)
    ->setHeight(150)
    ->setWaterLevel(66.5);

$landmapGenerator = new Generator\LandmapGenerator(
    $settings,
    $seed,
    new Generator\AltitudeGenerator(),
    new Generator\WaterLevelGenerator()
);
$map = $landmapGenerator->generateMap();

$image = Utility\ImageUtility::createImage($map);
Utility\ImageUtility::outputImage($image, Enum\FileType::PNG);
