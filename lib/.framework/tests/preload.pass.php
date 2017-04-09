<?php
/**
 * testPreload : Unit Testing class for "preload.class.php"
 *
 * @package     UnitTests\testPreload
 * @category    UnitTest
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace UnitTests;

use UnitTests\testPreload;
use WAFFLE\Framework\Engines\Template;

require_once __DIR__ . '/../template.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testPreload extends \PHPUnit.framework_TestCase {
    protected $template;

    /**
     * Invoke Method : Call protected/private method(s) within a testing class.
     *
     * @param           Object &object                  Instantiated object that we will run method on.
     * @param           String methodName               Method name to call
     * @param           Array  parameters               Array of parameters to pass into method.
     *
     * @return          Mixed                           Method
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($methodName);

        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * setUp : Instantiate '$template' object to run subsequently recurring tests
     */
    public function setUp()
    {
        $assets = 'C:/xampp/htdocs/lib/.framework/tests/assets/';               # Location: of vital assets for unit testing
        $this->template = new Template($assets . 'testTemplate.wad');           # Instantiate: new template with a phony template file
    }

    /**
     * get_lib_dirs : Returns an array that contains various combinations that a user can legally
     * initiate through Preload::get_lib_dirs
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function set_script()
    {   // '/../modernizr/modernizr.dev-v2.8.3.js',
        return array(
            array(      # CASE [0]:
                'modernizr',
                'C:\xampp\htdocs\lib\modernizr\modernizr.dev-v2.8.3.js'
            ),
            array(      # CASE [1]:
                'jquery',
                'C:\xampp\htdocs\lib\jquery\jquery-1.11.3.min.js'
            ),
            array(      # CASE [2]:
                // '/../-prefix-free/prefixfree.min.js',
                '-prefix-free',
                'C:\xampp\htdocs\lib\-prefix-free\prefixfree.min.js'
            )
        );
    }

    /**
     * Tests Preload::set_script method, which [Description]
     *
     * @dataProvider set_script
     */
    public function test_set_script_method($file, $expected)
    {
        $result = $this->preload->set_script($file);
        $this->assertEquals($expected, $result);
    }

    /**
     * illegally_set_script_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Preload::illegally_set_script
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function illegally_set_script_provider()
    {
        return array(
            array(
                'modernizer'
            ),
            array(
                'jQuery-2'
            ),
            array(
                '-previxfree'
            ),
            array(
                'prefix-free'
            ),
            array(
                'prefixfree'
            )
        );
    }

    /**
     * Tests Preload::illegally_set_script method, which [Description]
     *
     * @dataProvider illegally_set_script_provider
     */
    public function test_illegally_set_script($file)
    {
        $result = $this->preload->set_script($file);
        $this->assertFalse($result);
    }
}