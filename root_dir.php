<?php
if (!function_exists('root_dir')) {
    function root_dir(): string
    {
        return defined("PHP_DUMMY_SERVER_ROOT_DIR")?constant("PHP_DUMMY_SERVER_ROOT_DIR"):__dir__;
    }
}