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
 * @package    Mu-Cli
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Cli;

/**
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 * @uses       \Mu\Cli\Request
 * @uses       \Mu\Cli\Response
 */
class TestCase extends \Mu\Core\TestCase {
    /**
     * Argv used during test cases
     * @var array
     */
    static protected $_argv;

    /**
     * Gets the Argv to be used during test cases
     * @return array
     */
    static public function getArgv() {
        return static::$_argv;
    }

    /**
     * Sets the Argv to be used during test cases
     * @param array $argv
     * @return void
     */
    static public function setArgv(array $argv) {
        static::$_argv = $argv;
    }

    /**
     * Creates a \Mu\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Cli\Response
     */
    public function createRequest($options = null) {
        $response = new \Mu\Cli\Request($options);
        $response->setDelegate('getInput', array('\Mu\Cli\TestCase', 'getInput'));

        return $response;
    }

    /**
     * Creates a \Mu\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Cli\Response
     */
    public function createResponse($options = null) {
        $response = new \Mu\Cli\Response($options);
        $response->setDelegate('write', array('\Mu\Cli\TestCase', 'setOutput'));

        return $response;
    }

    /**
     * Resets argv
     * @return void
     */
    public function resetDelegatesVars() {
        parent::resetDelegatesVars();
        static::$_argv = array();
    }
}
