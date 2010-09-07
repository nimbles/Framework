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
 * @package    Mu-Core
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Response;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Mixin\MixinAbstract
 * @uses      \Mu\Core\Config\Options
 *
 * @property  string $body
 */
abstract class ResponseAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * The response body
     * @var string
     */
    protected $_body;

    /**
     * Gets the response body
     * @return string
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * Sets the response body
     * @param string $body
     * @return \Mu\Core\Response\ResponseAbstract
     */
    public function setBody($body) {
        $this->_body = is_string($body) ? $body : $this->_body;
        return $this;
    }

    /**
     * Class construct
     * @param array|null $options
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Magic __get to provide accesses for body
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if ('body' === $name) {
            return $this->getBody();
        }

        return parent::__get($name);
    }

    /**
     * Magic __set to provide accesses for body
     * @param string $name
     * @param mixed  $value
     * @return mixed
     */
    public function __set($name, $value) {
        if ('body' === $name) {
            return $this->setBody($value);
        }

        return parent::__set($name, $value);
    }

    /**
     * Sends the response
     * @return void
     */
    abstract public function send();
}