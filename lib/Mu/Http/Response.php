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
	 * Class implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Config\Options',
	    'Mu\Core\Delegates\Delegatable' => array(
	        'delegates' => array(
				'headers_sent' => 'headers_sent',
				'header' => 'header',
	            'write' => array('\Mu\Http\Response', 'writeBody')
	        )
	    )
	);

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
	 * Sets the headers, clears out any existing
	 * @param array $headers
	 * @return \Mu\Http\Response
	 */
	public function setHeaders(array $headers) {
	    $this->_headers = array();
	    foreach ($headers as $name => $header) {
	        if (is_string($name)) {
	            $this->setHeader($name, $header);
	        } else {
	            $this->setHeader($header);
	        }
	    }

		return $this;
	}

	/**
	 * Gets a header by its name
	 * @param string $name
	 * @return \Mu\Http\Header|null
	 */
	public function getHeader($name) {
	    if (array_key_exists($name, ($headers = $this->getHeaders()))) {
	        return $headers[$name];
	    }

	    return null;
	}

	/**
	 * Sets a header
	 * @param string|\Mu\Http\Header		     $name
	 * @param string|\Mu\Http\Header|array|null  $value
	 * @param bool							     $append
	 * @return \Mu\Http\Response
	 */
	public function setHeader($name, $value = null, $append = false) {
	    if (!is_array($this->_headers)) {
	        $this->_headers = array();
	    }

	    if ($name instanceof Header) {
	        $this->setHeader($name->getName(), $name->getValue());
	    } else if (is_string($name)) {
	        if ($value instanceof Header) {
	            $name = $value->getName(); // sync to the headers name
	            $value = $value->getValue(); // converts to null, string or array
	        }

	        if (is_string($value) || (null === $value)) {
	            $value = array($value);
	        }

	        foreach ($value as $string) {
	            $header = Header::factory($name, $string);
	            $name = $header->getName();

	            if (array_key_exists($name, $this->_headers)) {
		            $this->_headers[$name]->merge($header);
		        } else {
		            $this->_headers[$name] = $header;
		        }
	        }
	    }


		return $this;
	}

	/**
	 * Gets the http status
	 * @return \Mu\Http\Status
	 */
	public function getStatus() {
	    if (null === $this->_status) {
	        $this->_status = new Status(Status::STATUS_OK);
	    }
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
		if (!$this->headers_sent()) {
			foreach ($this->getHeaders() as $header) {
				$this->header((string) $header);
			}

			// set the status last due to php changing the status if a location header has been sent
			$this->header((string) $this->getStatus());
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

		$this->write($this->getBody());
	}

	/**
	 * Writes the body
	 * @param string $body
	 * @return void
	 */
	static public function writeBody($body) {
	    echo $body;
	}
}