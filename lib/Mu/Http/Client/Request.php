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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Http\Client;

use Mu\Http\Client,
    Mu\Http;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\Client
 * @uses       \Mu\Http
 */
class Request extends Http\Request {
    /**
     * Request URI
     * @var string
     */
    protected $_requestUri;

    /**
     * Get the request URI
     * @return string
     */
    public function getRequestUri() {
        return $this->_requestUri;
    }

    /**
     * Set the request URI
     * @param string $value
     * @return Request
     */
    public function setRequestUri($value) {
        if (!is_string($value)) {
            throw new Exception('Request URI must be a string');
        }

        $this->_requestUri = (string)$value;
        return $this;
    }
}