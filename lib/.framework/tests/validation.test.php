<?php
/**
 * testValidation : Unit Testing class for "validation.class.php"
 *
 * @package     UnitTests\testValidation
 * @category    UnitTest
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace UnitTests;

use UnitTests\testValidation;
use WAFFLE\Framework\IO\Validation;

require_once __DIR__ . '/../validation.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testValidation extends \PHPUnit.framework_TestCase {
    protected $validation;

    /**
     * setUp : Instantiate '$validation' object to run subsequently recurring tests
     */
    public function setUp()
    {
        $this->validation = new Validation;             # Instantiate: new validation with a phony validation file
    }

    /**
     * email_format_provider : Returns an array that contains various combinations that a user can
     * not legally initiate through Validation::email_format
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function illegally_formatted_email_provider()
    {
        // Strings that do not adhere towards email formatting standards
        return array(
            array(      # [0] CASE: incorrectly formatted email
                'email'
            ),
            array(      # [1] CASE: incorrectly formatted email
                'email@address'
            ),
            array(      # [2] CASE: incorrectly formatted email
                'email@address.'
            ),
            array(      # [3] CASE: incorrectly formatted email in Array
                array(
                    'email',
                    'email@address',
                    'email@address.'
                )
            )
        );
    }

    /**
     * Tests Validation::email_format method, which validates the email passed is a properly
     * formatted address; i.e., email@server.net
     *
     * &@method Boolean email_format(String $email)
     *
     * @return Boolean                                  description
     *
     * @dataProvider illegally_formatted_email_provider
     */
    public function test_email_format_method_with_illegal_values($email)
    {
        $this->assertFalse($this->validation->email_format($email));
    }

    /**
     * email_format_provider : Returns an array that contains various combinations that a user can
     * legally initiate through Validation::email_format
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function legally_formatted_email_provider()
    {
        // Strings that do adhere towards email formatting standards
        return array(
            array(      # [0] CASE: correctly formatted email
                'email@address.com'
            ),
            array(      # [0] CASE: correctly formatted email
                'e@address.net'
            ),
            array(      # [0] CASE: correctly formatted email
                'email@a.co'
            ),
            array(      # [0] CASE: correctly formatted email in Array
                array(
                    'email@address.com',
                    'e@address.net',
                    'email@a.co'
                )
            )
        );
    }

    /**
     * Tests Validation::email_format method, which validates the email passed is a properly
     * formatted address; i.e., email@server.net
     *
     * &@method Boolean email_format(String $email)
     *
     * @return Boolean                                  description
     *
     * @dataProvider legally_formatted_email_provider
     */
    public function test_email_format_method_with_legal_values($email)
    {
        $this->assertTrue($this->validation->email_format($email));
    }
}