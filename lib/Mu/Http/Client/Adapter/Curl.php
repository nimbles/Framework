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
namespace Mu\Http\Client\Adapter;

use Mu\Http\Client,
    Mu\Http\Client\Adapter,
    Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       Mu\Http\Client
 * @uses       Mu\Http\Client\Adapter
 * @uses       Mu\Core\Config
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
     * @return \Mu\Http\Client\Adapter\Curl
     */
    public function setCurlOptions($value) {
        if ($value instanceof \Mu\Core\Config) {
            $value = $value->getArrayCopy();
        }

        if (!is_array($value)) {
            throw new Curl\Exception('Curl options must an array or an instance of \\Mu\\Core\\Config');
        }

        $this->_curlOptions = $value;
        return $this;
    }

    /**
     * Write request
     * @return \Mu\Http\Client\Response
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
