<?php
/**
 * Parses files contents prior to writing, modifying, or returning contents once read from source.
 *
 * @package     Framework\IO\File
 * @category    IO
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 * @copyright   2010-2016 Byrne-Systems
 */

namespace WAFFLE\Framework\IO;

use WAFFLE\Framework\IO\File;
use WAFFLE\Framework\IO\Validation;

require_once 'validation.class.php';

/**
 * File IO
 *
 * Class designed to handle various file read, write, and modify methods
 */
class File extends Validation {


    /**
     * Attempts to locate the filename passed through the set_script method
     *
     * @method String find_file(String $file)
     *
     * @param           String $file                    The filename to be recursively searched for throughout the parent directory passed via the __construct'or
     * @return          String                          The directory in which the filename (being searched for) exists
     *
     * @todo complete subroutine for set_script injection routine
     */
    private function find_file($file) {
        $data = NULL;
        $pack = NULL;

        if (!isset($file)) {
            $File->error('empty filename submitted!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
        } else {
            $data = scandir($this->lib_dir);            # Scan: this application's library directory for the folder for the script file being searched for
            $file = strtolower($file);                  # Convert: passed filename to lowercase to avoid file incongruity
        }

        foreach ($data as $key => $value) {
            if ($value == $file) {
                # Scan: 'lib' directory appended with this file's (found) directory name (or '$value')
                $data = scandir($this->lib_dir . $value . '\\');
                foreach ($data as $key => $value) {
                    $data = strpbrk($value, $file);     # Identify: whether the folder (previous found) contains the '$file' passed
                    $pack = '\\' . $data;               # Append: a backlash at the beginning of the identified package (or '$file')

                    # Return: full (or real) path of the '$file' passed if '$data' is equivocal to a string
                    if (is_string($data)) return $data = realpath($file) . $pack;
                }
            }
        }

        return false;
    }

    ####################################################################
    ###                          Public                              ###
    ####################################################################

    /**
     * Forces a download on the client-side using this server-side method
     *
     * @method Mixed download(String $file)
     *
     * @param           String $file                    Filename (and/or directory) of the file to be returned/downloaded on the client's system
     * @return          Mixed                           The requested file
     */
    public function download($file) {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
    /**
     * Reads an assortment of flat file types to be returned to the originating method
     *
     * @method Mixed read(String $file, Mixed $return_type, $String $key)
     *
     * @param           String $file                    Filename (and/or directory) of the file to be returned to the originating method
     * @param           Mixed  $rtn_tp                  Return type or the variable type to return the requested file
     * @param           String $latchkey                Credential(s) to pass to decrypt file, if necessary
     * @return          Mixed                           Contents of the requested file
     */
    public function read($file, $rtn_tp, $latchkey) {
        if (file_exists($file)) {

        }
    }

    /**
     * Writes passed content into the filename passed @params appended after the filename's
     * last entry
     *
     * @method Boolean write(String $file, String $content, String $type)
     *
     * @param           String $file                description
     * @param           String $content                 description
     * @param           String $type                    description
     * @return          Boolean                         description
     */
    public function write($file, $content, $type = 'script') {
        // $dir  = '/../../data/';
        $dir  = '/../../';
        $mode = 'a';

        if (isset($file) && isset($content)) {
            switch ($type) {
                case 'file':
                    $file = __DIR__ . $dir . 'data/' . $file;
                    break;
                case 'log':
                    $file = __DIR__ . $dir . 'data/' . $type . 's/' . $file  . '.log';
                    break;
                case 'json':
                    $file = __DIR__ . $dir . 'data/' . $type . '/' . $file . '.json';
                    $content = json_encode($content, JSON_UNESCAPED_SLASHES);                       # -Flag: JSON_UNESCAPED_SLASHES: don't insert '\' slashes throughout Array|String
                    $mode = 'w';                        # Mode: open for R/W, while placing pointer at beginning of file after truncating file to zero length
                    break;
                case 'script':
                    $file = __DIR__ . $dir . 'web/views/' . $file . '.wad';
                    // $mode = 'w';
                    break;
                default:
                    $this->error('Improper (or unknown) filetype passed!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
                    return false;
                    break;
            }
            $file = fopen($file, $mode);
            fwrite($file, $content . PHP_EOL);
            fclose($file);                              # Close: file
        }
        return true;
    }
}