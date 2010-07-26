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
 * @category  Mu\Cli
 * @package   Mu\Cli\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Cli;

require_once 'PHPUnit/Framework.php';

/**
 * @category  Mu\Cli
 * @package   Mu\Cli\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class TestCase extends \Mu\Core\TestCase {
    /**
     * Gets the Argv to be used during test cases
     * @return array
     */
    public function getArgv() {
        return $this->_argv;
    }

    /**
     * Sets the Argv to be used during test cases
     * @param array $argv
     * @return void
     */
    public function setArgv(array $argv) {
        $this->_argv = $argv;
    }

    /**
     * Creates a \Mu\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Cli\Response
     */
    public function createRequest($options = null) {
        $response = new \Mu\Cli\Request($options);
        $response->setDelegate('getInput', array($this, 'getInput'));

        return $response;
    }

    /**
     * Creates a \Mu\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Cli\Response
     */
    public function createResponse($options = null) {
        $response = new \Mu\Cli\Response($options);
        $response->setDelegate('write', array($this, 'setOutput'));

        return $response;
    }
}
