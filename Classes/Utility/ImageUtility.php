<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Enum\FileType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;

/**
 * ImageUtility
 */
class ImageUtility
{
    /**
     * Output the image directly to the browser
     *
     * @param resource $image
     * @param string $fileType
     */
    public static function outputImage($image, string $fileType): void
    {
        switch ($fileType) {
            case FileType::PNG:
                self::outputPNG($image);
                break;
            case FileType::JPEG:
                self::outputJPEG($image);
                break;
            case FileType::GIF:
                self::outputGIF($image);
                break;
            case FileType::WEBP:
                self::outputWEBP($image);
                break;
            default:
                throw new \InvalidArgumentException('File type ' . $fileType . ' is not supported.');
        }
    }

    /**
     * Saves an image to the specified file path
     *
     * @param resource $image
     * @param string $filePath
     *
     * @return bool
     */
    public static function saveImage($image, string $filePath): bool
    {
        $fileType = strtolower(end(explode('.', $filePath)));

        switch ($fileType) {
            case FileType::PNG:
                return imagepng($image, $filePath);
                break;
            case FileType::JPEG:
                return imagejpeg($image, $filePath);
                break;
            case FileType::GIF:
                return imagegif($image, $filePath);
                break;
            case FileType::WEBP:
                return imagewebp($image, $filePath);
                break;
            default:
                throw new \InvalidArgumentException('File type ' . $fileType . ' is not supported.');
        }
    }

    /**
     * Returns an image resource generated from the map
     *
     * @param Map $map
     *
     * @return resource
     */
    public static function createImage(Map $map)
    {
        $width = $map->width;
        $height = $map->height;
        $imageResource = imagecreatetruecolor($width, $height);

        foreach (ArrayIterator::getMapIterator($map) as $x => $y) {
            $color = $map->colors[$x][$y];
            $allocatedColor = self::allocateColor($imageResource, $color);
            imagesetpixel($imageResource, $x, $y, $allocatedColor);
        }

        return $imageResource;
    }

    /**
     * @param resource $image
     * @param Color $color
     *
     * @return int
     */
    protected static function allocateColor($image, Color $color): int
    {
        return imagecolorallocate($image, $color->r, $color->g, $color->b);
    }

    /**
     * @param $image
     */
    protected static function outputPNG($image): void
    {
        header('Content-Type: image/png');
        imagepng($image);
        exit;
    }

    /**
     * @param $image
     */
    protected static function outputJPEG($image): void
    {
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        exit;
    }

    /**
     * @param $image
     */
    protected static function outputGIF($image): void
    {
        header('Content-Type: image/gif');
        imagegif($image);
        exit;
    }

    /**
     * @param $image
     */
    protected static function outputWEBP($image): void
    {
        header('Content-Type: image/webp');
        imagewebp($image);
        exit;
    }

}