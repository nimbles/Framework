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
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Http;

use Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @uses       \Nimbles\Core\Collection
 */
class Header extends Collection {
    /**
     * The header name
     * @var string
     */
    protected $_name;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @param array|null $options
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $fixed = array(
            'type'      => 'string',
            'indexType' => static::INDEX_NUMERIC
        );
        
        $options = (null == $options) ? $fixed : array_merge($options, $fixed);
        parent::__construct($array, $options);
        
        if (array_key_exists('name', $options)) {
            $this->setName($options['name']);
        }
    }
    
    /**
     * Gets the header name
     * @return string
     */
    public function getName() {
        return $this->_name;
    }
    
    /**
     * Sets the header name
     * @param string $name
     * @return \Nimbles\App\Http\Header
     * @throws \Nimbles\App\Http\Header\Exception\InvalidName
     */
    public function setName($name) {
        if (!is_string($name) || (0 === strlen($name))) {
            throw new Header\Exception\InvalidName('Header name must be a string and must not be zero length');
        }
        
        $name = implode('-', array_map('ucfirst', preg_split('/[_\-]/', strtolower(trim($name)))));
        switch ($name) { // apply corrections
            case 'Etag' :
                $name = 'ETag';
                break;

            case 'Te' :
                $name = 'TE';
                break;

            case 'Www-Authenticate' :
                $name = 'WWW-Authenticate';
                break;
        }
        
        $this->_name = $name;
        return $this;
    }
    
    /**
     * Sends the header
     * @return \Nimbles\App\Http\Header
     * @throws \Nimbles\App\Http\Header\Exception\HeadersAlreadySent
     */
    public function send() {
        if (headers_sent()) {
            throw new Header\Exception\HeadersAlreadySent('Cannot send header as headers have already been sent');
        }
        
        header((string) $this);
        return $this;
    }
    
    /**
     * Removes the header if it hasn't already been sent
     * @return \Nimbles\App\Http\Header
     * @throws \Nimbles\App\Http\Header\Exception\HeadersAlreadySent
     */
    public function remove() {
        if (headers_sent()) {
            throw new Header\Exception\HeadersAlreadySent('Cannot remove header as headers have already been sent');
        }
        
        header_remove($this->getName());
        return $this;
    }
    
    /**
     * Represents the header as a string
     * @return string
     */
    public function __toString() {
        return sprintf('%s: %s', $this->getName(), implode(', ', $this->getArrayCopy()));   
    }
}