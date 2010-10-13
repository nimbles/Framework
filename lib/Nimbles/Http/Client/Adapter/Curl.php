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
    Nimbles\Http\Client\Adapter,
    Nimbles\Core\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       Nimbles\Http\Client
 * @uses       Nimbles\Http\Client\Adapter
 * @uses       Nimbles\Core\Config
 */
class Curl extends AdapterAbstract {

    /**
     * Curl options
     * @var array
     */
    protected $_curlOptions = array();

    /**
     * Default Curl options
     * @var array
     */
    protected $_defaultCurlOptions = array(
        CURLOPT_TIMEOUT => 10
    );

    /**
     * Get the curl options
     * @return array
     */
    public function getCurlOptions() {
        return $this->_curlOptions;
    }

    /**
     * Set the curl options
     * @param array|Config $value
     * @return \Nimbles\Http\Client\Adapter\Curl
     */
    public function setCurlOptions($value) {
        if ($value instanceof \Nimbles\Core\Config) {
            $value = $value->getArrayCopy();
        }

        if (!is_array($value)) {
            throw new Curl\Exception('Curl options must an array or an instance of \\Nimbles\\Core\\Config');
        }

        $this->_curlOptions = $value;
        return $this;
    }

    /**
     * Write request
     * @return \Nimbles\Http\Client\Response
     */
    public function write() {
        $curlOptions = array_merge($this->_defaultCurlOptions, $this->getCurlOptions());

        $curlOptions[CURLOPT_URL] = $this->_request->getRequestUri();
        $curlOptions[CURLOPT_CUSTOMREQUEST] = $this->_request->getMethod();
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_HEADER] = true;

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);

        if (!$result = curl_exec($ch)) {
            throw new Curl\Exception(curl_error($ch));
        }
        curl_close($ch);

        $response = new Client\Response();
        $response->setRawResponse($result);

        return $response;
    }
}
