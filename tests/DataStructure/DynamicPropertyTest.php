<?php

use TPFoundation\DataStructure\DynamicProperty;

class D extends DynamicProperty
{

}

class DynamicPropertyTest extends PHPUnit_Framework_TestCase
{
    public function test_init()
    {
        $d = new D();
        $d->mym = 'MyM';
        $this->assertEquals('MyM', $d->mym);
    }
}
