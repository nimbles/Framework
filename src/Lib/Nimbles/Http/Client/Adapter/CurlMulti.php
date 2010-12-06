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
namespace Nimbles\Http\Client\Adapter;

use Nimbles\Http\Client,
    Nimbles\Http\Client\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\Client\Adapter
 */
class CurlMulti extends Curl implements AdapterMultiInterface {
    /**
     * Requests instance
     * @var \Nimbles\Http\Client\Request
     */
    protected $_requests;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Set the request
     * @param \Nimbles\Http\Client\Request $request
     */
    public function setRequest(Client\Request $request) {
        $this->_requests = array($request);
    }

    /**
     * Set an array of request objects
     * @param \Nimbles\Http\Client\Request[] $requests
     */
    public function setRequests($requests) {
        $this->_requests = array();
        foreach ($requests as $request) {
            if (!($request instanceof Client\Request)) {
                throw new Adapter\Exception('Request is not of type Client\Request');
            }
        }
        $this->_requests = $requests;
    }

    /**
     * Write request
     * @return \Nimbles\Http\Client\Response
     */
    public function write() {
        $curlOptions = array_merge($this->_defaultCurlOptions, $this->getCurlOptions());
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_HEADER] = true;

        $multiHandle = curl_multi_init();
        $arrayOfHandles = array();

        foreach ($this->_requests as $request) {
            $curlOptions[CURLOPT_URL] = $request->getRequestUri();
            $curlOptions[CURLOPT_CUSTOMREQUEST] = $request->getMethod();
            $curlHandle = curl_init();
            curl_setopt_array($curlHandle, $curlOptions);
            curl_multi_add_handle($multiHandle, $curlHandle);
            $arrayOfHandles[(int) $curlHandle] = $request;
        }

        $running = null;
        do {
            usleep(1000);
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);


        $responses = array();
        while ($curlData = curl_multi_info_read($multiHandle)) {
            $request = $arrayOfHandles[(int) $curlData['handle']];

            $result = curl_multi_getcontent($curlData['handle']);
            $response = new Client\Response();
            $response->setRawResponse($result);

            $responses[] = array (
                'request' => $request,
                'response' => $response
            );
        }

        return $responses;

    }
}
