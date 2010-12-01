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
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Pattern\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
trait Adaptable {
    /**
     * Gets the adapter
     * @return object|null
     */
    public function getAdapter() {
        return $this->getAdapterObject()
            ->getAdapter();
    }
    
    /**
     * Sets the adapter
     * 
     * If the adapter passed in is a string, then the method will automatically
     * attempt to create an instance of the class within the provided options
     * 
     * @param string|object $adapter
     */
    public function setAdapter($adapter) {
        $adapter = $this->getAdapterObject();
        return call_user_func_array(array($adapter, 'setAdapter'), func_get_args());
    }
    
    /**
     * Gets the adapter object, using getConfig to provide the options
     * @return \Nimbles\Core\Pattern\Adapter
     */
    public function getAdapterObject() {
        if (!isset($this->adapter)) {
            if (!method_exists($this, 'getConfig')) {
                throw new \Nimbles\Core\Pattern\Adapter\Exception\InvalidConfig(
                	'When implmenting Adaptable, a getConfig method must exist'
                );           
            }
            
            $config = $this->getConfig('adapter');
            
            if (!is_array($config) && !($config instanceof \ArrayObject)) {
                throw new \Nimbles\Core\Pattern\Adapter\Exception\InvalidConfig(
                	'When implmenting Adaptable, getConfig should provide an array for adapter'
                );
            }
            
            if ($config instanceof \ArrayObject) {
                $config = $config->getArrayCopy();
            }
            
            $this->adapter = new \Nimbles\Core\Pattern\Adapter($config);
        } else if (!($this->adapter instanceof \Nimbles\Core\Pattern\Adapter)) {
            throw new \Nimbles\Core\Pattern\Adapter\Exception\InvalidInstance(
        		'adapter property is not an instance of Nimbles\Core\Pattern\Adapter'
            );
        }
        
        return $this->adapter;
    }
}