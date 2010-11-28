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
 * @package    Nimbles-Config
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Config;

use Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @uses       \Nimbles\Config\Exception\InvalidValue
 */
class Config extends Collection {
	/**
     * Static instance
     * @var \Nimbles\Config\Config
     */
    protected static $_instance;

    /**
     * Gets the instance
     * @return \Nimbles\Config\Config
     */
    public static function getInstance() {
        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }
    
    /**
     * Class construct
     * 
     * @param array|\ArrayObject $array
     * @param array $options
     */
    public function __construct($array = null, array $options = null) {
        $options = array_merge(
            (null === $options) ? array(
                'readonly' => false,
            ) : $options,
            array(
                'indexType' => static::INDEX_ASSOCITIVE,
            )
        );
        
        parent::__construct($array, $options);
        $this->setFlags(static::ARRAY_AS_PROPS);
    }
    
	/**
     * Merges a source config with overriding values
     * @param array|\ArrayObject $override
     * @return array
     * @throws \Nimbles\Config\Exception\InvalidConfig
     */
    public function merge($override) {
        if (!(is_array($override) || ($override instanceof \ArrayObject))) {
            throw new Config\Exception\InvalidConfig('Override must be an array or an instanceof \ArrayObject, recieved: ' . gettype($override));
        }

        foreach ($override as $key => $value) {
            if ($this->offsetExists($key) && ($this->$key instanceof Config) &&
                (is_array($value) || ($value instanceof \ArrayObject))
            ) {
                $this->$key->merge($value);
            } else {
                $this->$key = $value;
            }
        }
    }
    
    /**
     * Factory method to create allowed config values
     * 
     * This is called when adding a value to a Config value
     * 
     * @param mixed $value
     * @return scalar|\Nimbles\Config\Config
     * @throws \Nimbles\Config\Exception\InvalidValue
     */
    public static function factory($index, $value) {
        if (is_scalar($value) || (null === $value)) {
            return $value;
        }
        
        if ($value instanceof Config) {
            return $value;   
        }
        
        if (is_array($value) || ($value instanceof \ArrayObject)) {
            return new Config($value);
        }
        
        throw new Exception\InvalidValue('Config values can only be array or scalar');
    }
}