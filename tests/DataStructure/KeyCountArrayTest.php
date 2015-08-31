<?php

use TPFoundation\DataStructure\KeyCountArray;

class KeyCountArrayTest extends PHPUnit_Framework_TestCase
{
    public function test_add()
    {
        $a = new KeyCountArray();
        $this->assertNotNull($a);

        $a->add('1', 'data-1');
        $a->add('1', 'data-1-1');
        $a->add('2', 'data-2');

        $this->assertTrue(true);
    }

    public function test_remove()
    {
        $a = new KeyCountArray();
        $a->add('1', 'data-1');
        $a->add('1', 'data-1-1');
        $a->add('2', 'data-2');
        $this->assertEquals(3, $a->count());

        // Test Count remove
        $a->remove('1');
        $this->assertEquals(2, $a->count());

        // Test Force
        $a->add('2', 'data-2');
        $a->remove('2', $force=true);
        $this->assertTrue(true);
        $this->assertEquals(1, $a->count());
    }

    public function test_iterator()
    {
        //
        // Mock
        $mock = $this->getMock('stdClass', array('runned'));
        $mock->expects($this->at(1))->method('runned')->will($this->returnValue(true));


        // Test
        $a = new KeyCountArray();
        $a->add('1', 'data-1');
        $a->add('1', 'data-1-1');
        $a->add('2', 'data-2');
        foreach($a as $key => $value) {
            $mock->runned();
        }

        $this->assertEquals(3, $a->count());
    }
}
