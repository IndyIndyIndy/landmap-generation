<?php

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);

use \ChristianEssl\LandmapGeneration\Generator\LandmapGenerator;
use \ChristianEssl\LandmapGeneration\Settings\DefaultSettings;

$seed = 'testseed';
$landmapGenerator = new LandmapGenerator(new DefaultSettings(), $seed);
$map = $landmapGenerator->generateMap();

var_dump($map);