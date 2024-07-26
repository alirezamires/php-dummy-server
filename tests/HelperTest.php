<?php


use Alirezamires\DummyServer\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testSizeToHumanConvert()
    {
        $this->assertEquals('1 kb',Helper::sizeToHumanConvert(1024));
    }
}
