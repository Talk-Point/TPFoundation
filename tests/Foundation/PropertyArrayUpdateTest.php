<?php

class A
{
    use \TPFoundation\Foundation\PropertyArrayUpdate;

    protected $a;

    /**
     * @return mixed
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param mixed $a
     */
    public function setA($a)
    {
        $this->a = $a;
    }
}

class B extends A
{
    protected $b;

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param mixed $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }
}


class PropertyArrayUpdateTest extends PHPUnit_Framework_TestCase
{
    public function test_update_propertys()
    {
        // Mock
        $csvArray = ['a' => 'a', 'b' => 'b'];

        // Test
        $b = new B();
        $b->updateFromCSVArray($csvArray);
        $this->assertEquals($b->getA(), 'a');
        $this->assertEquals($b->getB(), 'b');

    }

    public function test_update_propertys_set_class()
    {
        // Mock
        $csvArray = ['a' => 'a', 'b' => 'b'];

        // Test
        $b = new B();
        $b->updateFromCSVArray($csvArray, 'B');
        $this->assertEquals($b->getA(), null);
        $this->assertEquals($b->getB(), 'b');

    }
}
