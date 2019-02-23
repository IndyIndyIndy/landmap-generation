<?php

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);

use \ChristianEssl\LandmapGeneration\Generator\LandmapGenerator;
use \ChristianEssl\LandmapGeneration\Settings\DefaultSettings;

$map = LandmapGenerator::createFromSettings(new DefaultSettings())
    ->seed('TODO')
    ->generateMap();

//var_dump($map);