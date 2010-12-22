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
 * @package    Nimbles-Service
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Service\Response;

use Nimbles\Service\Http\Header,
    Nimbles\Service\Http\Parameters;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Http extends ResponseAbstract {
    /**
     * The http headers
     * @var \Nimbles\Service\Http\Header\Collection
     */
    protected $_headers;
    
	/**
     * Gets a header
     * @param string|null $name If NULL then the collection is returned
     * @return \Nimbles\Service\Http\Header|\Nimbles\Service\Http\Header\Collection|null
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
                $original = array_merge($original, $value);
            }
            
            $value = $original;
        }
        $this->getHeader()->offsetSet($name, $value);
    }
}