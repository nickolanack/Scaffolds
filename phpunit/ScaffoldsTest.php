<?php

class ScaffoldsTest extends PHPUnit_Framework_TestCase {

    /**
     * @runInSeparateProcess
     */
    public function testIncludehelper() {
        include_once dirname(__DIR__) . '/scaffolds/defines.php';
        
        $this->assertEquals(true, class_exists('Scaffolding'));
        $this->assertEquals(true, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testInclude() {
        include_once dirname(__DIR__) . '/scaffolds/scaffolding.php';
        $this->assertEquals(true, class_exists('Scaffolding'));
        $this->assertEquals(false, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testInclude() {
        include_once dirname(__DIR__) . '/scaffolds/scaffolding.php';
        $this->assertEquals(true, class_exists('Scaffolding'));
        $this->assertEquals(false, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testScaffoldDocument() {
        include_once dirname(__DIR__) . '/scaffolds/defines.php';
        
        ob_start();
        
        HTML('document', array(
            'header' => function () {},
            'body' => function () {}
        ));
        
        $content = ob_get_contents();
        ob_end_clean();
    }
}