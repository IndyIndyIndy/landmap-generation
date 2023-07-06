<?php

namespace ChristianEssl\LandmapGeneration\Enum;

enum FileType: string
{
    case PNG = 'png';
    case JPEG = 'jpeg';
    case GIF = 'gif';
    case WEBP = 'webp';
}