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
 * @package    Nimbles-Cli
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Cli;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 * @uses       \Nimbles\Cli\Request
 * @uses       \Nimbles\Cli\Response
 */
class TestCase extends \Nimbles\Core\TestCase {
    /**
     * Argv used during test cases
     * @var array
     */
    protected static $_argv;

    /**
     * Gets the Argv to be used during test cases
     * @return array
     */
    public static function getArgv() {
        return static::$_argv;
    }

    /**
     * Sets the Argv to be used during test cases
     * @param array $argv
     * @return void
     */
    public static function setArgv(array $argv) {
        static::$_argv = $argv;
    }

    /**
     * Creates a \Nimbles\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Nimbles\Cli\Response
     */
    public function createRequest($options = null) {
        $request = new \Nimbles\Cli\Request($options);
        $request->setDelegate('getInput', array('\Nimbles\Cli\TestCase', 'getInput'));
        $request->setDelegate('getServerRaw', array('\Nimbles\Http\TestCase', 'getServer'));

        return $request;
    }

    /**
     * Creates a \Nimbles\Cli\Response with the test delegate methods
     * @param array|null $options
     * @return \Nimbles\Cli\Response
     */
    public function createResponse($options = null) {
        $response = new \Nimbles\Cli\Response($options);
        $response->setDelegate('write', array('\Nimbles\Cli\TestCase', 'setOutput'));

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
