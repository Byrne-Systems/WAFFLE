<?php
/**
 * Specifies a series of standard methods that should be implemented by default
 *
 * @package     Interfaces\iHTML
 * @category    Interface
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WAFFLE\Framework\Interfaces;

use WAFFLE\Framework\Interfaces\iHTML;

/**
 * Interface for HTML class
 *
 * Standard interface for the HTML Engine class
 */
interface iHTML {
    // private function get_domain();
    // private function meta_type($rule);
    // private function parse_id_type($rule);

    ####################################################################
    ###                          Public                              ###
    ####################################################################

    public function anchor($href, $content, $title = NULL, $accy);      # [1]
    public function favicon($data);                                     # [2]
    public function link($href, $rel, $media = NULL, $download = false);# [3]
    public function mailto($mailto , $cc, $bcc, $sub, $body, $content); # [4]
    public function meta($name, $content);                              # [5]
    public function script($src, $type = 'text/javascript');            # [6]
    public function tag($content, $tag);                                # [7]
}
?>