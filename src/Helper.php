<?php

namespace Alirezamires\DummyServer;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Helper
{
    /**
     * Get Directory Size.
     *
     * @return int
     */
    public static function GetDirectorySize($path)
    {
        $total = 0;
        $path = realpath($path);
        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $total += $object->getSize();
            }
        }

        return $total;
    }

    /**
     * get directory contents [recursive].
     */
    public static function getDirContents($dir, array &$results = []): array
    {
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } elseif ($value != '.' && $value != '..') {
                Helper::getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return array_filter($results, static function ($item) {
            return filesize($item) > 0;
        });
    }

    public static function sizeToHumanConvert($size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        return @round($size / pow(1024, $i = floor(log($size, 1024))), 2) . ' ' . $unit[$i];
    }
}
