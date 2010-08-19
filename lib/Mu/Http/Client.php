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

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Client\Adapter,
    Mu\Http\Client\Exception,
    Mu\Http\Client\Adapter\Curl;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Http\Client\Adapter
 * @uses       \Mu\Http\Client\Exception
 * @uses       \Mu\Http\Client\Adapter\Curl
 */
class Client extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Adapter\Adaptable' => array(
            'interface' => 'Mu\Http\Client\Adapter\AdapterInterface',
            'namespaces' => array(
                '\Mu\Http\Client\Adapter'
            )
        ),
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
     * Valid HTTP Methods
     * @return array
     */
    static public function getValidHTTPMethods() {
        return array ('GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS');
    }
}
