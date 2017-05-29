<?php

class ScaffoldsTest extends PHPUnit\Framework\TestCase {

    /**
     * @runInSeparateProcess
     */
    public function testIncludehelper() {
        include_once dirname(__DIR__) . '/vendor/autoload.php';
        include_once dirname(__DIR__) . '/src/defines.php';
        $this->assertEquals(true, class_exists('nickolanack\Scaffolding'));
        $this->assertEquals(true, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testInclude() {
        include_once dirname(__DIR__) . '/vendor/autoload.php';
        $this->assertEquals(true, class_exists('nickolanack\Scaffolding'));
        $this->assertEquals(false, function_exists('HTML'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testScaffoldDocument() {
        include_once dirname(__DIR__) . '/src/defines.php';
        
        ob_start();
        
        HTML('document', array(
            'header' => function () {},
            'body' => function () {}
        ));
        
        $content = ob_get_contents();
        ob_end_clean();
    }
}