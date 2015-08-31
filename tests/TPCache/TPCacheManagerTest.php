<?php

use TPFoundation\Cache\TPCacheManager;

class TPCacheManagerTest extends TestCase
{
    public function test_get()
    {
        $manager = new TPCacheManager();

        $this->assertEquals($manager->getOrCreate('/the/path', function() {
            return 'aerogjaoperjgaopejrgopajerg';
        }, 100), 'aerogjaoperjgaopejrgopajerg');
    }

    public function test_get_path_array()
    {
        $manager = new TPCacheManager();

        $this->assertEquals($manager->getOrCreate(['mein', 'neuer', 'path', 'array'], function() {
            return 'aerogjaoperjgaopejrgopajerg';
        }, 100), 'aerogjaoperjgaopejrgopajerg');
    }

    public function test_get_and_set()
    {
        $manager = new TPCacheManager();

        // Setze Item
        $manager->set(['mein', 'neuer', 'path', 'setzen'], 'meine neuen daten');

        // Get
        $this->assertTrue($manager->getItem(['mein', 'neuer', 'path', 'setzen']) instanceof Stash\Item);
        $this->assertEquals($manager->getItem(['mein', 'neuer', 'path', 'setzen'])->get(), 'meine neuen daten');
        $this->assertEquals('meine neuen daten', $manager->get(['mein', 'neuer', 'path', 'setzen']));
    }

    public function test_set()
    {
        $manager = new TPCacheManager();

        $manager->set(['mein', 'neuer', 'pathsetze'], 'meine neuen daten');

        $this->assertEquals($manager->getOrCreate(['mein', 'neuer', 'pathsetze'], function() {
            return 'other';
        }, 100), 'meine neuen daten');
    }

    public function test_clear()
    {
        $manager = new TPCacheManager();

        $manager->set(['mein', 'neuer', 'pathsetze'], 'meine neuen daten');
        $this->assertEquals('meine neuen daten', $manager->get(['mein', 'neuer', 'pathsetze']));
        $manager->clearPath(['mein', 'neuer', 'pathsetze']);
        $this->assertEquals(null, $manager->get(['mein', 'neuer', 'pathsetze']));
        $manager->set(['mein', 'neuer', 'pathsetze'], 'meine neuen daten');
        $this->assertEquals(null, $manager->get(['mein']));

    }
}
