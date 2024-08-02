<?php

use Alirezamires\DummyServer\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function test_size_to_human_convert()
    {
        $this->assertEquals('1 kb', Helper::sizeToHumanConvert(1024));
    }
}
