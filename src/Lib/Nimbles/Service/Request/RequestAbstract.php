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

namespace Nimbles\Service\Request;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Options
 */
abstract class RequestAbstract {
    /**
     * The request body
     * @var string|null
     */
    protected $_body;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }
 
    /**
     * Gets the request body
     * @return string|null
     */
    public function getBody() {
        return $this->_body;
    }
    
    /**
     * Sets the request body
     * @param string|null $body
     * @return \Nimbles\Service\Request\RequestAbstract
     */
    public function setBody($body) {
        $this->_body = $body;
        return $this;
    }
}