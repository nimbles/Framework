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
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Http\Client,
    Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Header
 * @uses       \Mu\Http\Status
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
     * Client constructor
     *
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
     * @return Client
     */
    public function setMethod($method) {
        if (!is_string($method)) {
            throw new Client\Exception('Method must be of type string');
        }

        $validMethods = array_map('strtoupper', $this->getValidMethods());
        $method = strtoupper($method);
        if (!in_array($method, $validMethods)) {
            throw new Client\Exception('Invalid HTTP method [' . $method . ']');
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