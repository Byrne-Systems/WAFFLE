<?php
/**
 * testFile : Unit Testing class for "file.class.php"
 *
 * @package     UnitTests\testFile
 * @category    UnitTest
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace UnitTests;

use UnitTests\testFile;
use WAFFLE\Framework\IO\File;

require_once __DIR__ . '/../file.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testFile extends \PHPUnit.framework_TestCase {
    protected $file;

    /**
     * Returns the current date for logging, indexing, or anything else requiring a timestamp
     *
     * @method String get_date()
     *
     * @return          String                          Return the current time; correctly formatted
     */
    private function get_date() {
        date_default_timezone_set('America/Los_Angeles');
        return "[ " . date('l jS \of F Y h:i:s A') . " ] ";
    }

    /**
     * setUp : Instantiate '$file' object to run subsequently recurring tests
     */
    public function setUp()
    {
        $this->file = new File;                         // Instantiate: new file object to run a series of unit-tests
    }

    /**
     * legally_formatted_write_file_provider : Returns an array that contains various combinations
     * that a user can legally initiate through File::write
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function legally_formatted_write_file_provider()
    {

        $json_array = array(
            "title"   => "Byrne-Systems",
            "author"  => "Justin D. Byrne",
            "e-mail"  => "just@byrne-systems.com",
            "website" => "http://www.byrne-systems.com",
            "time stamp" => $this->get_date()
        );

        // $json_array = json_encode($json_array);

        return array(
            array(      # [0] CASE: file
                'file',
                'file created' . $this->get_date(),
                'file'
            ),
            array(      # [1] CASE: data
                'data',
                'data log created' . $this->get_date(),
                'log'
            ),
            array(      # [2] CASE: json (0) | RETURNS: ["zero","one","two","three"]
                'json',
                array(
                    0 => 'zero',
                    1 => 'one',
                    2 => 'two',
                    3 => 'three'
                ),
                'json'
            ),
            array(      # [3] CASE: json (1) | RETURNS: ["zero","one","two","three"]
                'json',
                array(
                    0 => "zero",
                    1 => "one",
                    2 => "two",
                    3 => "three"
                ),
                'json'
            ),
            array(      # [4] CASE: json (2) | RETURNS: ["zero","one","two","three"]
                'json',
                array(
                    "0" => "zero",
                    "1" => "one",
                    "2" => "two",
                    "3" => "three"
                ),
                'json'
            ),
            array(      # [5] CASE: json (3) | RETURNS: {"zero":"0","one":"1","two":"2","three":"3"}
                'json',
                array(
                    "zero" => "0",
                    "one" => "1",
                    "two" => "2",
                    "three" => "3"
                ),
                'json'
            ),
            array(      # [6] CASE: json (4) | RETURNS: {"header":{"body":true,"footer":"bottom"},"extra stuff":false,"tag":"!","number":3}
                'json',
                array(
                    "header" => array(
                        "body" => true,
                        "footer" => "bottom"
                        ),
                    "extra stuff" => false,
                    "tag" => "!",
                    "number" => 3
                ),
                'json'
            ),
            array(      # [7] CASE: json (5) | RETURNS: {"title":"Byrne-Systems","author":"Justin D. Byrne","e-mail":"just@byrne-systems.com","website":"http://www.byrne-systems.com","time stamp":"[ Sunday 21st of February 2016 09:36:55 AM ] "}
                'json',
                $json_array,
                'json'
            )
        );
    }

    /**
     * Tests File::write method, which writes passed content into the filename passed @params
     * appended after the filename's
     *
     * @dataProvider legally_formatted_write_file_provider
     */
    public function test_write_method_with_legal_values($filename, $content, $type)
    {
        $this->assertTrue($this->file->write($filename, $content, $type));
    }

    /**
     * illegally_formatted_write_file_provider : Returns an array that contains various combinations
     * that a user can legally initiate through File::write
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function illegally_formatted_write_file_provider()
    {
        return array(   # [0] CASE: file
            array(
                'file',
                'file not created',
                ''
            )
        );
    }

    /**
     * Tests File::write method, which writes passed content into the filename passed @params
     * appended after the filename's
     *
     * @dataProvider illegally_formatted_write_file_provider
     */
    public function test_write_method_with_illegal_values($filename, $content, $type)
    {
        $this->assertFalse($this->file->write($filename, $content, $type));
    }
}