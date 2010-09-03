<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Header;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Header\Exception\InvalidHeaderName
 */
class Header extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Delegates\Delegatable' => array(
                'delegates' => array(
                    'headers_sent' => 'headers_sent',
                    'header' => 'header'
                )
            ),
            'Mu\Core\Config\Options'
        );
    }

    /**
     * The header name
     * @var string
     */
    protected $_name;

    /**
     * The header values
     * @var array
     */
    protected $_values;

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
     * @return \Mu\Http\Header
     * @throws \Mu\Http\Header\Exception\InvalidHeaderName
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new Header\Exception\InvalidHeaderName('Header name must be a string');
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
     * Gets the header value
     * @return array|string|null
     */
    public function getValue() {
        if (!is_array($this->_values)) {
            $this->_values = array();
        }

        switch (count($this->_values)) {
            case 0 :
                return null;

            case 1 :
                return $this->_values[0];

        }

        return $this->_values;
    }

    /**
     * Sets the value
     *
     * @param array|string|null $value if null, clears value
     * @param bool $append
     * @return \Mu\Http\Header
     */
    public function setValue($value, $append = false) {
        if (!is_array($this->_values)) {
            $this->_values = array();
        }

        if (empty($value)) {
            $this->_values = array();
        } else if (!is_array($value)) {
            if ($append) {
                $this->_values[] = $value;
            } else {
                $this->_values = array($value);
            }
        } else {
            $this->_values = $value;
        }

        return $this;
    }

    /**
     * Merges one header values into another
     * @param \Mu\Core\Http\Header $header
     * @return void
     * @throws \Mu\Http\Header\Exception\InvalidHeaderName
     */
    public function merge(Header $header) {
        if ($this->getName() !== $header->getName()) {
            throw new Header\Exception\InvalidHeaderName('Cannot merge headers of different name');
        }

        $values = $header->getValue(); // for header to create an array
        foreach ($header->_values as $value) {
            $this->setValue($value, true);
        }
    }

    /**
     * Class Construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Factory method for creating a header
     *
     * @param string            $name
     * @param string|null|array $value
     * @param bool              $fromServerVars indicates that the name and string came from the $_SERVER variables
     * @return \Mu\Http\Header
     */
    static public function factory($name, $value = null, $fromServerVars = false) {
        if (0 === strpos($name, 'HTTP_')) {
            $name = substr($name, 5);
        } else if ($fromServerVars) {
            return null;
        }

        if ((null === $value) && (false !== strpos($name, ':'))) {
            list($name, $value) = explode(':', $name, 2);
        }

        if (is_string($value)) {
            $value = explode(',', $value);
        } else if (null === $value) {
            $value = array('');
        }

        return new self(array(
            'name' => $name,
            'value' => array_map('trim', $value)
        ));
    }

    /**
     * Converts the header to a string
     * @return string
     */
    public function __toString() {
        $value = $this->getValue();

        if (is_array($value) && (0 < count($value))) {
            return sprintf('%s: %s', $this->getName(), implode(', ', $value));
        } else if (is_string($value) && (0 < strlen($value))) {
            return sprintf('%s: %s', $this->getName(), $value);
        }

        return sprintf('%s', $this->getName());
    }

    /**
     * Sends the header
     * @return void
     */
    public function send() {
        if ($this->headers_sent()) {
            throw new Header\Exception\HeadersAlreadySent('Cannot send header when headers have already been sent');
        }

        $this->header((string) $this);
    }
}
