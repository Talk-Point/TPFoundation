<?php

use TPFoundation\Parser\CSVParser;

class CSVParserTest extends PHPUnit_Framework_TestCase
{
    public function test_init()
    {
        $csv = new CSVParser(__DIR__.'/test.csv');
        $this->assertNotNull($csv);
    }

    public function test_parse()
    {
        //
        // Mock
        $mock = $this->getMock('stdClass', array('runnedHeader', 'runnedLine'));
        // 1 mal Header Callen
        $mock->expects($this->never())->method('runnedHeader')->will($this->returnValue(true));
        // 4 mal Line Callen
        $mock->expects($this->at(3))->method('runnedLine')->will($this->returnValue(true));

        //
        // Test
        $csv = new CSVParser(__DIR__.'/test.csv');
        $csv->parse($headerCall=function() use ($mock){
            $mock->runnedHeader();
            return true;
        }, $lineCall=function($line_array, $line_string, $line_count) use ($mock) {
            $mock->runnedLine();
            return true;
        });

        $this->assertFalse($csv->isErrorByParsing());
    }

    public function test_parse_max_min()
    {
        //
        // Mock
        $mock = $this->getMock('stdClass', array('runnedHeader', 'runnedLine'));
        // 2 mal Line Callen
        $mock->expects($this->at(2))->method('runnedLine')->will($this->returnValue(true));

        //
        // Test
        $csv = new CSVParser(__DIR__.'/test.csv', $options=[
            'line_start' => 1,
            'line_end' => 3,
            'is_header' => true
        ]);
        $csv->parse($headerCall=function() use ($mock){
            $mock->runnedHeader();
            return true;
        }, $lineCall=function($line_array, $line_string, $line_count) use ($mock) {
            $mock->runnedLine();
            return true;
        });

        $this->assertFalse($csv->isErrorByParsing());
    }

    public function test_parse_delimiter()
    {
        //
        // Mock
        $mock = $this->getMock('stdClass', array('runnedHeader', 'runnedLine'));
        // 1 mal Header Callen
        $mock->expects($this->never())->method('runnedHeader')->will($this->returnValue(true));
        // 4 mal Line Callen
        $mock->expects($this->at(3))->method('runnedLine')->will($this->returnValue(true));

        //
        // Test
        $csv = new CSVParser(__DIR__.'/test-delimiter.csv', $options=[
            'delimiter' => '|',
            'enclosure' => '"',
            'escape' => '\\'
        ]);
        $csv->parse($headerCall=function() use($mock){
            $mock->runnedHeader();
            return true;
        }, $lineCall=function($line_array, $line_string, $line_count) use ($mock) {
            $mock->runnedLine();
            return true;
        });

        $this->assertFalse($csv->isErrorByParsing());
    }

    public function test_errorraise()
    {
        $csv = new CSVParser(__DIR__.'/test.csv');
        $csv->parse($headerCall=function(){
            return false;
        }, $lineCall=function($line_array, $line_string, $line_count){
           return false;
        });

        $this->assertTrue($csv->isErrorByParsing());
    }

}
