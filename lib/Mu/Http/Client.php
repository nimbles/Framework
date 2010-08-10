<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
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

namespace Mu\Http;

use Mu\Http\Client\Adapter\Curl;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Client\Adapter,
    Mu\Http\Client\Exception;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Client\Exception\InvalidAdapter
 * @uses       \Mu\Http\Client\Exception\InvalidMethod
 */

class Client extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Config\Options',
        'Mu\Core\Delegates\Delegatable' => array(
            'delegates' => array(
                'getValidMethods' => array('\Mu\Http\Client', 'getValidHTTPMethods')
            )
        )
    );

    /**
     * HTTP method
     * @var string
     */
    protected $_method = null;

    /**
     * Client adapter
     * @var unknown_type
     */
    protected $_adapter = null;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Get the HTTP method
     * @return string
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * Set the HTTP method
     * @param string $method
     * @return \Mu\Http\Client
     * @throws \Mu\Http\Client\Exception\InvalidMethod
     */
    public function setMethod($method) {
        if (!is_string($method)) {
            throw new Exception\InvalidMethod('Method must be of type string');
        }

        $validMethods = array_map('strtoupper', $this->getValidMethods());
        $method = strtoupper($method);
        if (!in_array($method, $validMethods)) {
            throw new Exception\InvalidMethod('Invalid HTTP method [' . $method . ']');
        }

        $this->_method = $method;
        return $this;
    }

    /**
     * Get the HTTP adapter
     * @return \Mu\Http\Client\Adapter\AdapterAbstract
     */
    public function getAdapter() {
        return $this->_adapter;
    }

    /**
     * Set the HTTP Adapter
     * @param object|string $adapter
     * @return \Mu\Http\Client
     * @throws \Mu\Http\Client\Exception\InvalidAdapter
     */
    public function setAdapter($adapter) {
        // @todo move this functionality to a factory

        if (is_string($adapter) && strlen($adapter) > 0) {
            if ($adapter[0] !== '\\') {
                $adapter = __CLASS__ . '\\Adapter\\' . $adapter;
            }
            if (!class_exists($adapter)) {
                throw new Exception\InvalidAdapter('Adapter [' . $adapter . '] must be valid class name');
            }
            $args = func_get_args();
            array_pop($args);
            $adapter = new $adapter($args);
        }

        if (!is_object($adapter)) {
            throw new Exception\InvalidAdapter('Adapter must be either a string or an object');
        } else if (!$adapter instanceof Adapter\AdapterInterface) {
            throw new Exception\InvalidAdapter('Adapter implement \Mu\Http\Client\Adapter\AdapterInterface');
        }

        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * Valid HTTP Methods
     * @return array
     */
    static public function getValidHTTPMethods() {
        return array ('GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS');
    }
}
