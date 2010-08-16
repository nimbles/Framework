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
 * @package    Mu-Http
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;


/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 */
class TestCase extends \Mu\Core\TestCase {
    /**
     * Indicates that the headers have been sent
     * @var bool
     */
    static protected $_headersSent;

    /**
     * Array of sent headers
     * @var array
     */
    static protected $_headers;

    /**
     * Creates a \Mu\Http\Request with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Request
     */
    public function createRequest($options = null) {
        $request = new Request($options);
        $request->setDelegate('getInput', array('\Mu\Http\TestCase', 'getInput'));

        return $request;
    }

    /**
     * Creates a \Mu\Http\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Response
     */
    public function createResponse($options = null) {
        $response = new Response($options);
        $response->setDelegate('write', array('\Mu\Http\TestCase', 'setOutput'));
        $response->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $response->setDelegate('headers_sent', array($this, 'isHeadersSent'));

        return $response;
    }

    /**
     * Creates a \Mu\Http\Header with the delegate methods
     * @param array|null $options
     * @return \Mu\Http\Header
     */
    public function createHeader($options = null) {
        $header = new Header($options);
        $header->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $header->setDelegate('headers_sent', array('\Mu\Http\TestCase', 'isHeadersSent'));

        return $header;
    }

    /**
     * Creates a \Mu\Http\Status with delegate methods
     * @param array|null $options
     * @return \Mu\Http\Status
     */
    public function createStatus($options = null) {
        $status = new Status($options);
        $status->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $status->setDelegate('headers_sent', array('\Mu\Http\TestCase', 'isHeadersSent'));

        return $status;
    }

    /**
     * Indicates that the headers have been sent
     * @return bool
     */
    static public function isHeadersSent($headersSent = null) {
        self::$_headersSent = is_bool($headersSent) ? $headersSent : self::$_headersSent;
        return self::$_headersSent;
    }

    /**
     * Appends a header
     *
     * @param string $header
     * @return void
     */
    static public function header($header) {
        self::$_headers[] = $header;
    }

    /**
     * Resets headers
     * @return void
     */
    public function resetDelegatesVars() {
        parent::resetDelegatesVars();
        self::$_headersSent = false;
        self::$_headers = array();
    }
}