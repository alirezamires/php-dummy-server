<?php
namespace Alirezamires\DummyServer;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Helper
{
    public static function GetDirectorySize($path){
        $total = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $total += $object->getSize();
            }
        }
        return $total;
    }
    public static function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                Helper::getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return array_filter($results, static function ($item) {
            return filesize($item) > 0;
        });
    }
}