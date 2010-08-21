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
    Mu\Http\Client,
    Mu\Http\Client\Adapter;

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
                'getDefaultAdapter' => array('\Mu\Http\Client', 'getDefaultAdapter')
            )
        )
    );


    /**
     * Last successful request
     * @var Request
     */
    protected $_lastRequest = null;

    /**
     * Last successful response
     * @var Request
     */
    protected $_lastResponse = null;

    /**
     * Last successful batch
     * @var Request
     */
    protected $_lastBatch = null;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Gets the last successful request
     * @return Request
     */
    public function getLastRequest() {
        return $this->_lastRequest;
    }

    /**
     * Set the last successful request
     * @param Request $request
     * @return Client
     */
    protected function _setLastRequest($request) {
        $this->_lastRequest = $request;
        return $this;
    }

    /**
     * Gets the last successful response
     * @return Response
     */
    public function getLastResponse() {
        return $this->_lastResponse;
    }

    /**
     * Set the last successful response
     * @param Response $request
     * @return Client
     */
    protected function _setLastResponse($response) {
        $this->_lastResponse = $response;
        return $this;
    }

    /**
     * Gets the last successful batch of request and responses
     * @return mixed
     */
    public function getLastBatch() {
        return $this->_lastBatch;
    }

    /**
     * Set the last successful batch of request and responses
     * @param mixed $batch
     * @return Client
     */
    protected function _setLastBatch($batch) {
        $this->_lastBatch = $batch;
        return $this;
    }

    /**
     * Request an HTTP resource
     * @param string|Client\Request $request
     * @param string|null $method
     * @return Client\Response
     */
    public function request($request, $method = NULL) {
        if (null === $this->getAdapter()) {
            $this->setAdapter($this->getDefaultAdapter());
        }

        $method = (null === $method) ? 'GET' : $method;

        if (is_array($request)) {
            // Check if all the items are request objects
            $preparedRequests = array();
            foreach($request as $aRequest) {
                $preparedRequests[] = $this->_prepareRequestInstance($aRequest, $method);
            }

            if (!($this->getAdapter() instanceof Adapter\AdapterMultiInterface)) {
                throw new Client\Exception('A multi adapter is required to process and array of requests');
            }
            $this->getAdapter()->setRequests($preparedRequests);
        } else {
            $this->getAdapter()->setRequest($request = $this->_prepareRequestInstance($request, $method));
        }

        $response = $this->getAdapter()->write();

        if (is_array($response)) {
            $this->_setLastBatch($response);
        } else {
            $this->_setLastRequest($request)
                 ->_setLastResponse($response);
        }

        return $response;
    }

    /**
     * Prepare the request by setting the method and ensuring it's of the correct type
     * @param Client\Request $request
     * @param string $method
     * @throws Client\Exception
     */
    protected function _prepareRequestInstance($request, $method) {
        if ($request instanceof Client\Request && null === $request->getMethod()) {
            $request->setMethod($method);
        } else if (is_string($request)) {
            $requestInstance = new Client\Request();
            $request = $requestInstance->setRequestUri($request)
                                       ->setMethod($method);
        }

        if (!($request instanceof Client\Request)) {
            throw new Client\Exception('Request must be either a \Mu\Http\Client\Request object or a URI string');
        }
        return $request;
    }

    /**
     * Returns the default adapter
     * @return mixed
     */
    static public function getDefaultAdapter() {
        return new Adapter\Curl();
    }
}
