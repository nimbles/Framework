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
 * @category  Mu\Http
 * @package   Mu\Http\Header
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

/**
 * @category  Mu\Http
 * @package   Mu\Http\Header
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Header extends \Mu\Core\Mixin\MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');

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
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new Header\Exception\InvalidHeaderName('Header name must be a string');
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
     * Class Construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Factory method for creating a header
     *
     * @param string $name
     * @param string $string
     * @param bool   $fromServerVars indicates that the name and string came from the $_SERVER variables
     * @return \Mu\Http\Header
     */
    static public function factory($name, $string, $fromServerVars = false) {
        if (0 === strpos($name, 'HTTP_')) {
            $name = substr($name, 5);
        } else if ($fromServerVars) {
            return null;
        }

        return new self(array(
            'name' => implode('-', array_map('ucfirst', preg_split('/[_\-]/', strtolower($name)))),
            'value' => array_map('trim', explode(',', $string))
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
}
