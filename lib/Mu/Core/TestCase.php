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
 * @category  Mu\Core
 * @package   Mu\Core\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  Mu\Core
 * @package   Mu\Core\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class TestCase extends \PHPUnit_Framework_TestCase {
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
}
