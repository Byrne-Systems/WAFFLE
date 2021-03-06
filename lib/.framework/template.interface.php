<?php
/**
* Specifies a series of standard methods that should be implemented by default
*
* @package      Interfaces\iTemplate
* @category     Interface
* @author       Justin D. Byrne <justin@byrne-systems.com>
*/

namespace WAFFLE\Framework\Interfaces;

use WAFFLE\Framework\Interfaces\iTemplate;

/**
 * Interface for Template class
 *
 * Standard interface for the Template Engine class
 */
interface iTemplate {
    public function set($key, $value);
    public function output();
    static public function merge($templates, $separator = "\n");
}
?>