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
}
