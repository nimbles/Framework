<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Core
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

require_once 'PHPUnit/Framework.php';

use PHPUnit_Framework_TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \PHPUnit_Framework_TestCase
 */
class TestCase extends PHPUnit_Framework_TestCase {
    /**
     * Input to be used during test cases
     * @var string
     */
    static protected $_input = '';

    /**
     * Output to be used during test cases
     * @var string
     */
    static protected $_output = '';

    /**
     * Gets input to be used during test cases
     * @return string
     */
    static public function getInput() {
        return static::$_input;
    }

    /**
     * Sets input to be used during test cases
     * @param string $input
     * @return void
     */
    static public function setInput($input) {
        static::$_input = is_string($input) ? $input : static::$_input;
    }

    /**
     * Gets output to be used during test cases
     * @return string
     */
    static public function getOutput() {
        return static::$_output;
    }

    /**
     * Sets output to be used during test cases
     * @param string $output
     */
    static public function setOutput($output) {
        static::$_output = is_string($output) ? $output : static::$_output;
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
