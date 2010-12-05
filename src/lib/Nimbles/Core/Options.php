<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 */
trait Options {
    /**
     * Gets an option
     * @param string $option
     * @return mixed
     * @throws \Nimbles\Core\Options\Exception\InvalidInstance
     */
    public function getOption($option) {
        $methods = array_map(
            function($prefix) use ($option) {
                return $prefix . ucfirst($option);
            },
            array('get', 'is')
        );
        
        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }
        
        if (!isset($this->options)) {
            $this->options = array();
        } else if (!is_array($this->options)) {
            throw new \Nimbles\Core\Options\Exception\InvalidInstance('options property is not an instance of an array');
        }
        
        return array_key_exists($option, $this->options) ? $this->options[$option] : null;
    }
    
    /**
     * Sets an option
     * @param string $option
     * @param mixed  $value
     * @return object The instance of the class which uses the trait
     * @throws \Nimbles\Core\Options\Exception\InvalidInstance
     */
    public function setOption($option, $value) {
        if (!isset($this->options)) {
            $this->options = array();
        } else if (!is_array($this->options)) {
            throw new \Nimbles\Core\Options\Exception\InvalidInstance('options property is not an instance of an array');
        }
        
        $methods = array_map(
            function($prefix) use ($option) {
                return $prefix . ucfirst($option);
            },
            array('set', 'is')
        );
        
        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                return $this->$method($value);
            }
        }
        
        $this->options[$option] = $value;
        return $this;
    }
    
    /**
     * Gets the options
     * @return array
     * @throws \Nimbles\Core\Options\Exception\InvalidInstance
     */
    public function getOptions() {
        if (!isset($this->options)) {
            $this->options = array();
        } else if (!is_array($this->options)) {
            throw new \Nimbles\Core\Options\Exception\InvalidInstance('options property is not an instance of an array');
        }
        
        return $this->options;
    }
    
    /**
     * Sets the options
     * @param array|\ArrayObject $options
     * @return The instance of the class which uses the trait
     * @throws \BadMethodCallException
     * @throws \Nimbles\Core\Options\Exception\MissingOption
     */
    public function setOptions($options, array $required = null, array $default = null) {
        if (null === $options) {
            return $this;
        }
        
        if (!is_array($options) && !($options instanceof \ArrayObject)) {
            throw new \BadMethodCallException('Invalid options, must be an array or instance of an ArrayObject');
        }
        
        if ($options instanceof \ArrayObject) {
            $options = $options->getArrayCopy();
        }
        
        if (null !== $default) {
            $options = array_merge($default, $options);
        }
        
        if (null !== $required) {
            foreach ($required as $requiredOption) {
                if (!array_key_exists($requiredOption, $options)) {
                    throw new \Nimbles\Core\Options\Exception\MissingOption('Missing required option ' . $requiredOption);
                }
            }
        }
        
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
        
        return $this;
    }
}