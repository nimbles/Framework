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
 * @category  Mu\Http
 * @package   Mu\Http\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

/**
 * @category  Mu\Http
 * @package   Mu\Http\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Response extends \Mu\Core\Response\ResponseAbstract {
	/**
	 * The collection of headers
	 * @var array
	 */
	protected $_headers;

	/**
	 * The http status code
	 * @var \Mu\Http\Status
	 */
	protected $_status;

	/**
	 * Indicates the response should be compressed
	 * @var bool
	 */
	protected $_compressed = false;

	/**
	 * Gets the headers
	 * @return array
	 */
	public function getHeaders() {
		if (null === $this->_headers) {
			$this->_headers = array();
		}

		return $this->_headers;
	}

	/**
	 * Sets the headers
	 * @param array $headers
	 * @return \Mu\Http\Response
	 */
	public function setHeaders(array $headers) {
		$this->_headers = $headers;
		return $this;
	}

	/**
	 * Sets a header
	 * @param string|array|\ArrayObject $name
	 * @param string|null               $value
	 * @return \Mu\Http\Response
	 */
	public function setHeader($name, $value = null) {
		if (is_array($name) || ($name instanceof \ArrayObject)) {
			foreach ($name as $index => $value) {
				if (is_numeric($index)) {
					$this->setHeader($value);
				} else {
					$this->setHeader($index, $value);
				}
			}
		} else if (null === $value) {
			list ($name, $value) = explode(':', $name, 2);
			if (null !== $value) {
				$this->setHeader($name, $value);
			}
		} else {
			if (null === $this->_headers) {
				$this->_headers = array();
			}

			/**
			 * @todo auto case the header name and use throughout to give consistent array key
			 */
			$name = trim($name);
			if (array_key_exists($name, $this->_headers) &&
				($this->_headers[$name] instanceof \Mu\Http\Header)
			) {
				$this->_headers[$name]->setValue($value, true);
			} else {
				$this->_headers[trim($name)] = \Mu\Http\Header::factory($name, $value);
			}
		}

		return $this;
	}

	/**
	 * Gets the http status
	 * @return \Mu\Http\Status
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * Sets the http status
	 * @param int|string|\Mu\Http\Status $status
	 * @return \Mu\Http\Response
	 */
	public function setStatus($status) {
		$this->_status = ($status instanceof \Mu\Http\Status) ? $status : new \Mu\Http\Status($status);
		return $this;
	}

	/**
	 * Gets if the response should be compressed
	 * @return bool
	 */
	public function getCompressed() {
	    return $this->_compressed;
	}

	/**
	 * Sets if the response should be compressed
	 * @param bool $compressed
	 * @return \Mu\Http\Response
	 */
	public function setCompressed($compressed) {
	    $this->_compressed = is_bool($compressed) ? $compressed : $this->_compressed;
	    return $this;
	}

	/**
	 * Sends the Http response
	 * @return void
	 */
	public function send() {
		if (!headers_sent()) {
			foreach ($this->getHeaders() as $header) {
				header((string) $header);
			}

			// set the status last due to php changing the status if a location header has been sent
			header((string) $this->getStatus());
		}

		if (
		    (Status::STATUS_NO_CONTENT === $this->getStatus()->getStatus()) ||
		    (Status::STATUS_NOT_MODIFIED === $this->getStatus()->getStatus())
		) {
		    return; // no body should be sent
		}

		if ($this->getCompressed() && extension_loaded('zlib')) {
		    ini_set('zlib.output_compression', '1');
		}

		echo $this->getBody();
	}
}