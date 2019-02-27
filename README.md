# landmap-generation
Generate pixelated, random world maps in PHP.

This is a simple landmap generator implemented in PHP. 
It supports generating an altitude map, setting up a water level, colorizing and shading.
The outputted result will be in pixel style.

![Screenshot](/Images/example.png)

## 1. Installation

`composer require christianessl/landmap-generation`. 

## 2. Usage

``` php
require __DIR__ . '/vendor/autoload.php';

use ChristianEssl\LandmapGeneration\Settings as Settings;
use ChristianEssl\LandmapGeneration\Generator as Generator;
use ChristianEssl\LandmapGeneration\Color as Color;
use ChristianEssl\LandmapGeneration\Color\Shader as Shader;
use ChristianEssl\LandmapGeneration\Enum as Enum;
use ChristianEssl\LandmapGeneration\Utility as Utility;

$seed = 'otters_are_awesome!';
$settings = (new Settings\MapSettings())
    ->setColorScheme(new Color\DefaultColorScheme(new Shader\FlatShader()))
    ->setWidth(500)
    ->setHeight(300)
    ->setWaterLevel(60);

$landmapGenerator = new Generator\LandmapGenerator($settings, $seed);
$map = $landmapGenerator->generateMap();

$image = Utility\ImageUtility::createImage($map);
Utility\ImageUtility::outputImage($image, Enum\FileType::PNG);
```

## 3. Example output

500x300 pixels

seed: 'otters_are_awesome!'

60% water, flat shader

![Screenshot](/Images/example.png)

30% water, flat shader

![Screenshot](/Images/example_2.png)

60% water, detailed shader

![Screenshot](/Images/example_3.png)

60% water, no shader

![Screenshot](/Images/example_4.png)


## 4. Configuration options

### Class MapSettings
| Public methods | Description | Default value |
| ------------- |-------------| -----|
| setWidth()      | map width in pixels | 150 |
| setHeight()      | map height in pixels      | 150 |
| setColorScheme() | the color scheme to use | DefaultColorScheme |
| setWaterLevel() | percentage of the map to be water | 70 |
| setInterpolationMode() | when set, only every fourth pixel is actually calculated in altitude generation. (as the calculation costs a lot of performance) Neighbouring pixels will be interpolated. Highly recommended. | true |

### Class DefaultColorScheme
| Constructor arguments | Description | Default value |
| ------------- |-------------| -----|
| ShaderInterface $shader | The shader to use for this color scheme. If none is passed, "NullShader" will be used (which does no shading at all). | NullShader |

### Implemented Shaders
| Class name | Description |
| ------------- |-------------| 
| NullShader | Does no shading at all. |
| FlatShader | Simple shading with flat looking colors. |
| DetailShader | Highly detailed altitudes in the map. No steps between the colors. |
