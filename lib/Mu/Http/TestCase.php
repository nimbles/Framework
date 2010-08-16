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
    protected $_headersSent;

    /**
     * Array of sent headers
     * @var array
     */
    protected $_headers;

    /**
     * Creates a \Mu\Http\Request with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Request
     */
    public function createRequest($options = null) {
        $request = new \Mu\Http\Request($options);
        $request->setDelegate('getInput', array($this, 'getInput'));

        return $request;
    }

    /**
     * Creates a \Mu\Http\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Response
     */
    public function createResponse($options = null) {
        $response = new \Mu\Http\Response($options);
        $response->setDelegate('write', array($this, 'setOutput'));

        $headers_sent =& $this->_headersSent;
        $response->setDelegate('headers_sent', function() use (&$headers_sent) {
            return $headers_sent;
        });

        $headers =& $this->_headers;
        $response->setDelegate('header', function($header) use (&$headers) {
            $headers[] = $header;
        });

        return $response;
    }

    /**
     * Resets headers
     * @return void
     */
    public function resetDelegatesVars() {
        parent::resetDelegatesVars();
        $this->_headersSent = false;
        $this->_headers = array();
    }
}