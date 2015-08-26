<?php

class ScaffoldsTest extends PHPUnit_Framework_TestCase {

    /**
     * @runInSeparateProcess
     */
    public function testIncludehelper() {
        include_once '../scaffolds/scaffolds/defines.php';
        
        $this->assertEquals(true, class_exists('Scaffolding'));
        $this->assertEquals(true, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testInclude() {
        include_once '../scaffolds/scaffolds/scaffolding.php';
        $this->assertEquals(true, class_exists('Scaffolding'));
        $this->assertEquals(false, function_exists('HTML'));
    }
}