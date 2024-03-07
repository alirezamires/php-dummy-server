<?php
if (!function_exists('root_dir')) {
    function root_dir(): string
    {
        return __dir__;
    }
}