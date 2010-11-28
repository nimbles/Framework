<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

use PHPUnit_Framework_TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \PHPUnit_Framework_TestCase
 */
class TestCase extends PHPUnit_Framework_TestCase {
    /**
     * Input to be used during test cases
     * @var string
     */
    protected static $_input = '';

    /**
     * Output to be used during test cases
     * @var string
     */
    protected static $_output = '';

    /**
     * The server variables
     * @var array
     */
    protected static $_server;

    /**
     * Gets input to be used during test cases
     * @return string
     */
    public static function getInput() {
        return static::$_input;
    }

    /**
     * Sets input to be used during test cases
     * @param string $input
     * @return void
     */
    public static function setInput($input) {
        static::$_input = is_string($input) ? $input : static::$_input;
    }

    /**
     * Gets output to be used during test cases
     * @return string
     */
    public static function getOutput() {
        return static::$_output;
    }

    /**
     * Sets output to be used during test cases
     * @param string $output
     */
    public static function setOutput($output) {
        static::$_output = is_string($output) ? $output : static::$_output;
    }

    /**
     * Gets the server variables
     * @return array
     */
    public static function getServer() {
        return static::$_server;
    }

    /**
     * Asserts that the collection is of a given type
     *
     * @param $type
     * @param $array
     * @param $message
     */
    public function assertCollection($type, $array, $message = '') {
        $this->assertThat(
            $array,
            $this->logicalOr(
                new \PHPUnit_Framework_Constraint_IsType('array'),
                new \PHPUnit_Framework_Constraint_IsInstanceOf('\ArrayObject')
            ),
            'Array must be an array or an instance of ArrayObject'
        );

        foreach ($array as $value) {
            $this->assertType($type, $value, $message);
        }
    }

    /**
     * Resets input and output
     * @return void
     */
    public function resetDelegatesVars() {
        static::$_input = '';
        static::$_output = '';
        static::$_server = array();
    }

    /**
     * Overrides so that variables used by delegates are reset, they may get missed if setUp was used
     * @return void
     */
    public function runBare() {
        $this->resetDelegatesVars();
        return parent::runBare();
    }
}
