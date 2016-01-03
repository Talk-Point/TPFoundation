<?php

/**
 * Created by PhpStorm.
 * User: konstantinstoldt
 * Date: 04/09/15
 * Time: 11:06
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
    public function test_tpenv()
    {
        // Test Envirement variable Exists
        putenv('Test=MyVar');
        $w = tpenv('Test');
        $this->assertEquals('MyVar', $w);

        // Test Variable Default
        $w = tpenv('NotExists', 'W');
        $this->assertEquals('W', $w);
    }

    public function test_tpenv_exception()
    {
        $exception = false;
        try {
            $w = tpenv('FORCE_LOGIN');
        } catch (Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception, 'Exception not firing');
    }

    public function test_underscoreToCamcelCase()
    {
        $string = 'preislistenfaktor_hersteller_a';

        $this->assertEquals('PreislistenfaktorHerstellerA', underscore2Camelcase($string));
    }

    public function test_array_has_keys()
    {
        // True
        $array = [
            'a' => 'a',
            'b' => 'b'
        ];
        $keys = ['a', 'b'];

        $this->assertTrue(array_has_keys($keys, $array));


        // False
        $array = [
            'a' => 'a',
        ];
        $keys = ['a', 'b'];

        $this->assertFalse(array_has_keys($keys, $array));
    }

    /*public function test_consul()
    {
        list($host, $port) = envconsul('redis-redis.service.consul', '127.0.0.1', 6379);
        var_dump($host, $port);
    }*/
}
