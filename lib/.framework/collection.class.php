<?php
/**
 * Collection Assembly designed as an OOP wrapper to wrap around an Array of Arrays (AoA) while using
 * lazy instantiation to create elements in this array
 *
 * @package     Framework\Assembly\Collection
 * @category    Assembly
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 * @copyright   2010-2016 Byrne-Systems
 */

namespace WAFFLE\Framework\Assembly;

use WAFFLE\Framework\Assembly\Collection;

/**
 * Collection Assembly
 *
 * Collection Assembly designed as an OOP wrapper to wrap around an Array of Arrays (AoA) while using
 * lazy instantiation to create elements in this array
 */
class Collection {
    /**
     * The $data array provides a location to store the objects that are members of a collection
     *
     * @access          protected
     * @var             Array $data
     */
    private $data = array();

    ####################################################################
    ###                          Public                              ###
    ####################################################################

    /**
     * Sets a new object in the $data collection using the $key to specify that location
     *
     * @method set(Object $obj, String $key)
     *
     * @param           Object $obj                     An object to be included inside this collection's array
     * @param           String $key                     The key used to identify the location of an entry inside of a collection's array
     */
    public function set($obj, $key = null)
    {
        // Verify: whether the current key, being passed, exists inside of this collection array
        if ($key == null) {
            $this->data[] = $obj;
        } else {
            if (isset($this->data[$key])) {
                throw new KeyHasUseException("Key $key already in use!");
            } else {
                $this->data[$key] = $obj;
            }
        }

        // code
    }

    /**
     * Deletes an entry (or item) stored inside of this collection
     *
     * @method del(String $key)
     *
     * @param           String $key                     The key used to identify the location of an entry inside of a collection's array
     */
    public function del($key)
    {
        // Verify: whether the current key, being passed, exists inside of this collection array
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        } else {
            throw new KeyInvalidException("Invalid key $key!");
        }
    }

    /**
     * Retrieves an entry (or item) stored inside of this collection
     *
     * @method get(String $key)
     *
     * @param           String $key                     The key used to identify the location of an entry inside of a collection's array
     */
    public function get($key)
    {
        // Verify: whether the current key, being passed, exists inside of this collection array
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            throw new KeyInvalidException("Invalid key $key.");
        }
    }

    /**
     * Returns a list of keys existing throughout this collection
     *
     * @method get_keys()
     *
     * @return          Array                           List of keys that currently exist throughout this collection's array
     */
    public function get_keys()
    {
        return array_keys($this->data);
    }

    /**
     * Returns the value (or amount) of entries that exist throughout this collection
     *
     * @method length()
     *
     * @return          Integer                         Value representing the amount of entries that exist this collection
     */
    public function length()
    {
        return count($this->data);
    }

    /**
     * key_exists description
     *
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function key_exists($key)
    {
        return isset($this->data[$key]);
    }
}