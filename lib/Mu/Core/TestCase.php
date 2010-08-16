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
    protected $_input = '';

    /**
     * Output to be used during test cases
     * @var string
     */
    protected $_output = '';

    /**
     * Gets input to be used during test cases
     * @return string
     */
    public function getInput() {
        return $this->_input;
    }

    /**
     * Sets input to be used during test cases
     * @param string $input
     * @return void
     */
    public function setInput($input) {
        $this->_input = is_string($input) ? $input : $this->_input;
    }

    /**
     * Gets output to be used during test cases
     * @return string
     */
    public function getOutput() {
        return $this->_output;
    }

    /**
     * Sets output to be used during test cases
     * @param string $output
     */
    public function setOutput($output) {
        $this->_output = is_string($output) ? $output : $this->_output;
    }

    /**
     * Asserts that the collection is of a given type
     *
     * @param $type
     * @param $array
     * @param $message
     */
    public function assertCollection($type, $array, $message = '') {
        $this->assertThat($array, $this->logicalOr(
            new \PHPUnit_Framework_Constraint_IsType('array'),
            new \PHPUnit_Framework_Constraint_IsInstanceOf('\ArrayObject')
        ), 'Array must be an array or an instance of ArrayObject');

        foreach($array as $value) {
            $this->assertType($type, $value, $message);
        }
    }

    /**
     * Resets input and output
     * @return void
     */
    public function resetDelegatesVars() {
        $this->_input = '';
        $this->_output = '';
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
