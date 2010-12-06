<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Request;

use Nimbles\App\Http\Header,
    Nimbles\App\Http\Parameters;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Http extends RequestAbstract {
    /**
     * The http method
     * @var string
     */
    protected $_method;
    
    /**
     * The http headers
     * @var \Nimbles\App\Http\Header\Collection
     */
    protected $_headers;
    
    /**
     * The querystring parameters
     * @var \Nimbles\App\Http\Parameters
     */
    protected $_query;
    
    /**
     * The post parameters
     * @var \Nimbles\App\Http\Parameters
     */
    protected $_post;
    
    /**
     * Gets a header
     * @param string|null $name If NULL then the collection is returned
     * @return \Nimbles\App\Http\Header|\Nimbles\App\Http\Header\Collection|null
     */
    public function getHeader($name = null) {
        if (null === $this->_headers) {
            $this->_headers = new Header\Collection();
        }
        
        if (null === $name) {
            return $this->_headers;
        }
        
        return $this->_headers->offsetExists($name) ? $this->_headers[$name] : null;
    }
    
    /**
     * Sets a header
     * @param string $name
     * @param string|array $value
     * @param bool $append
     */
    public function setHeader($name, $value, $append = false) {
        if ($append && $this->getHeader()->offsetExists($name)) {
            $original = $this->getHeader($name)->getArrayCopy();
            
            if (is_string($value)) {
                $original[] = $value;
            } else if (is_array($value)) {
                $original += $value;
            }
            
            $value = $original;
        }
        $this->getHeader()->offsetSet($name, $value);
    }
    
    /**
     * Gets a query paramater by key
     * @param string|null $key If null all parameters are returned
     * @return \Nimbles\App\Http\Parameters|string|null
     */
    public function getQuery($key = null) {
        if (null === $this->_query) {
            $this->_query = new Parameters();
        }
        
        if (null === $key) {
            return $this->_query;
        }
        
        return $this->_query->offsetExists($key) ? $this->_query[$key] : null
    }
    
    /**
     * Sets a query value
     * @param string $key
     * @param string $value
     */
    public function setQuery($key, $value) {
        $this->getQuery()->offsetSet($key, $value);
        return $this;
    }
    
	/**
     * Gets a post paramater by key
     * @param string|null $key If null all parameters are returned
     * @return \Nimbles\App\Http\Parameters|string|null
     */
    public function getPost($key = null) {
        if (null === $this->_post) {
            $this->_post = new Parameters();
        }
        
        if (null === $key) {
            return $this->_post;
        }
        
        return $this->_post->offsetExists($key) ? $this->_post[$key] : null
    }
    
    /**
     * Sets a post value
     * @param string $key
     * @param string $value
     */
    public function setPost($key, $value) {
        $this->getPost()->offsetSet($key, $value);
        return $this;
    }
}