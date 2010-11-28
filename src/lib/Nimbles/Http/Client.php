<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Http;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Http\Client,
    Nimbles\Http\Client\Adapter,
    Nimbles\Http;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Http\Client
 * @uses       \Nimbles\Http\Client\Adapter
 * @uses       \Nimbles\Http
 */
class Client extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Adapter\Adaptable' => array(
                'interface' => 'Nimbles\Http\Client\Adapter\AdapterInterface',
                'namespaces' => array(
                    '\Nimbles\Http\Client\Adapter'
                )
            ),
            'Nimbles\Core\Config\Options',
            'Nimbles\Core\Delegates\Delegatable' => array(
                'delegates' => array(
                    'getDefaultAdapter' => function() {
                        return new Adapter\Curl();
                    }
                )
            )
        );
    }


    /**
     * Last successful request
     * @var \Nimbles\Http\Client\Request
     */
    protected $_lastRequest = null;

    /**
     * Last successful response
     * @var \Nimbles\Http\Client\Request
     */
    protected $_lastResponse = null;

    /**
     * Last successful batch
     * @var \Nimbles\Http\Client\Request
     */
    protected $_lastBatch = null;

    /**
     * Cookie jar instance
     * @var \Nimbles\Http\Cookie\Jar
     */
    protected $_cookieJar = null;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Gets the last successful request
     * @return \Nimbles\Http\Client\Request
     */
    public function getLastRequest() {
        return $this->_lastRequest;
    }

    /**
     * Set the last successful request
     * @param \Nimbles\Http\Client\Request $request
     * @return \Nimbles\Http\Client
     */
    protected function _setLastRequest(Client\Request $request) {
        $this->_lastRequest = $request;
        return $this;
    }

    /**
     * Gets the last successful response
     * @return \Nimbles\Http\Client\Response
     */
    public function getLastResponse() {
        return $this->_lastResponse;
    }

    /**
     * Set the last successful response
     * @param \Nimbles\Http\Client\Response $request
     * @return \Nimbles\Http\Client
     */
    protected function _setLastResponse(Client\Response $response) {
        if (null !== $response->getCookie() && 0 < $response->getCookie()->count() && null !== ($cookieJar = $this->getCookieJar())) {
            $cookieJar->setCookies($response->getCookie()->getArrayCopy());
        }
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
     * @return \Nimbles\Http\Client
     */
    protected function _setLastBatch($batch) {
        if (null !== ($cookieJar = $this->getCookieJar())) {
            foreach ($batch as $result) {
                $response = $result['response'];
                if (null !== $response->getCookie() && 0 < $response->getCookie()->count()) {
                    $cookieJar->setCookies($response->getCookie()->getArrayCopy());
                }
            }
        }

        $this->_lastBatch = $batch;
        return $this;
    }

    /**
     * Get the cookie jar instance
     * @return \Nimbles\Http\Cookie\Jar
     */
    public function getCookieJar() {
        return $this->_cookieJar;
    }

    /**
     * Set the cookie jar instance
     * @param \Nimbles\Http\Cookie\Jar $cookieJar
     * @return \Nimbles\Http\Client
     */
    public function setCookieJar(Cookie\Jar $cookieJar) {
        $this->_cookieJar = $cookieJar;
        return $this;
    }

    /**
     * Request an HTTP resource
     * @param string|\Nimbles\Http\Client\Request $request
     * @param string|null $method
     * @return \Nimbles\Http\Client\Response
     */
    public function request($request, $method = NULL) {
        if (null === $this->getAdapter()) {
            $this->setAdapter($this->getDefaultAdapter());
        }

        $method = (null === $method) ? 'GET' : $method;

        if (is_array($request)) {
            // Check if all the items are request objects
            $preparedRequests = array();
            foreach ($request as $aRequest) {
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
     * @param \Nimbles\Http\Client\Request $request
     * @param string $method
     * @throws \Nimbles\Http\Client\Exception
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
            throw new Client\Exception('Request must be either a \Nimbles\Http\Client\Request object or a URI string');
        }
        return $request;
    }
}
