<?php
/**
 * [Description]
 *
 * @package     Framework\IO\Log
 * @category    IO
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 * @copyright   2010-2016 Byrne-Systems
 */

namespace WAFFLE\Framework\IO;

use WAFFLE\Framework\IO\Log;

/**
 * Log IO
 *
 * [Description]
 */
class Log {
    /**
     * Log: error message in [data/logs/waffle.error.log] after shipping any HTML and/or PHP tags
     *
     * @param           String                          Message to display on the browser and write to [waffle.error.log]
     */
    public function log($msg) {
        $dir = '..\\..\\..\\data\\logs\\';

        $msg  = strip_tags($msg) . PHP_EOL;             // Strip: all HTML & PHP tags
        $path = __DIR__ . $dir . "waffle.error.log";

        error_log($msg, 3, $path);
    }
}