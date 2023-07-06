<?php

namespace ChristianEssl\LandmapGeneration\Utility;

use ChristianEssl\LandmapGeneration\Enum\FileType;
use ChristianEssl\LandmapGeneration\Struct\Color;
use ChristianEssl\LandmapGeneration\Struct\Map;
use InvalidArgumentException;

class ImageUtility
{
    /**
     * Output the image directly to the browser
     *
     * @param resource $image
     * @param FileType $fileType
     */
    public static function outputImage($image, FileType $fileType): never
    {
        switch ($fileType->value) {
            case FileType::PNG->value:
                self::outputPNG($image);
            case FileType::JPEG->value:
                self::outputJPEG($image);
            case FileType::GIF->value:
                self::outputGIF($image);
            case FileType::WEBP->value:
                self::outputWEBP($image);
            default:
                throw new InvalidArgumentException('File type ' . $fileType->value . ' is not supported.');
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
        $fileType = pathinfo($filePath)['extension'] ?? null;

        return match ($fileType) {
            FileType::PNG->value => imagepng($image, $filePath),
            FileType::JPEG->value => imagejpeg($image, $filePath),
            FileType::GIF->value => imagegif($image, $filePath),
            FileType::WEBP->value => imagewebp($image, $filePath),
            default => throw new InvalidArgumentException('File type ' . $fileType . ' is not supported.'),
        };
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
     * @param resource $image
     */
    protected static function outputPNG($image): never
    {
        header('Content-Type: image/png');
        imagepng($image);
        exit;
    }

    /**
     * @param resource $image
     */
    protected static function outputJPEG($image): never
    {
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        exit;
    }

    /**
     * @param resource $image
     */
    protected static function outputGIF($image): never
    {
        header('Content-Type: image/gif');
        imagegif($image);
        exit;
    }

    /**
     * @param resource $image
     */
    protected static function outputWEBP($image): never
    {
        header('Content-Type: image/webp');
        imagewebp($image);
        exit;
    }
}