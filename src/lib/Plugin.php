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
 * @package    Nimbles-Plugins
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Plugins;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugins
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @uses       \Nimbles\Plugins\Exception\InvalidName
 */
class Plugin extends \Nimbles\Core\Collection {
	/**
     * The plugin type
     * @var string
     */
    protected $_type;

    /**
     * Gets the plugin type
     * @return string
     */
    public function getType() {
        return $this->_type;
    }
    
	/**
     * Sets the plugin type
     * @param string $type
     * @return \Nimbles\Plugins\Plugin
     * @throws \Nimbles\Plugins\Exception\InvalidType
     */
    public function setType($type) {
        if (!is_string($type)) {
            throw new Plugins\Exception\InvalidType('Plugin type must be a string: ' . $name);
        }

        $this->_type = $type;
        return $this;
    }
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {        
        $options = array_merge(
            (null === $options) ? array() : $options,
            array(
                'indexType' => static::INDEX_ASSOCITIVE,
                'readonly' => false
            )
        );
        
        if (array_key_exists('type', $options)) {
            $this->setType($options['type']);
        }
        
        parent::__construct($array, $options);
    }
    
    /**
     * Attaches a plugin
     * @param string $name
     * @param mixed $plugin
     * @return \Nimbles\Plugins\Plugin
     */
    public function attach($name, $plugin) {
        $this[$name] = $plugin;
        return $this;
    }
    
    /**
     * Detaches a plugin
     * @param string $name
     * @return \Nimbles\Plugins\Plugin
     */
    public function detach($name) {
        if ($this->offsetExists($name)) {
            $this->offsetUnset($name);
        }
        
        return $this;
    }
}