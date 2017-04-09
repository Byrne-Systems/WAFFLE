<?php
/**
 * Pre-loads special code, jobs, libraries, or style-sheets prior to an Bootstrap document (or application)
 * rendering its body (or content).
 *
 * @package     Framework\Template\Preload
 * @category    IO
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 * @copyright   2010-2016 Byrne-Systems
 */

namespace WAFFLE\Framework\IO;

use WAFFLE\Framework\IO\Preload;
use WAFFLE\Framework\Engines\Bootstrap;
use WAFFLE\Framework\IO\File;

require_once 'bootstrap.class.php';
require_once 'file.class.php';

/**
 * Preload IO
 *
 * Pre-loads unique code prior to the HTML document (or application) being fully rendered.
 */
class Preload extends Bootstrap {
    /**
     * Object to contain the File class, which parses, writes, and modifies files contents or returns
     * a file's contents once read from source
     *
     * @access          protected
     * @var             Object $lib_dir
     */
    protected $File;                                    # Reserved: storage space for a 'File' Object

    ####################################################################
    ###                          Public                              ###
    ####################################################################

    /**
     * Accepts a directory that holds/stores code, modules, or libraries that can be embedded in the
     * generated WAFFLE web-application or document.
     *
     * @param           String $dir                     Absolute path for the directory to search in for any ancillary code
     */
    public function __construct() {
        $this->File  = new File;                        # Instantiate: a new 'File' object
    }

    /**
     * Locates the exact file passed through the first param of this method while writing it into
     * WAFFLE's default script file [../web/views/script.wad]
     *
     * @method void set_script(String $script)
     *
     * @param           String $script                  The filename of the code (or module) to set
     *
     * @todo    Develop file-version logic for method, so that developers can pass a simple filename
     *          in accompaniment with the version that they are attempting to set
     */
    public function set_script($script) {
        if (!isset($script)) {
            $File->error('empty filename submitted!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
        } else {
            $src = $File->find_file($script);
            if (!$src) {
                $File->write('script', $script, 'script');
            }
        }
    }
}