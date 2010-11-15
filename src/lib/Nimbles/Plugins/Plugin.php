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
     * The plugin name
     * @var string
     */
    protected $_name;

    /**
     * Gets the plugin name
     * @return string
     */
    public function getName() {
        return $this->_name;
    }
    
	/**
     * Sets the plugin name
     * @param string $name
     * @return \Nimbles\Plugins\Plugin
     * @throws \Nimbles\Plugins\Exception\InvalidName
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new Plugins\Exception\InvalidName('Plugin name must be a string: ' . $name);
        }

        $this->_name = $name;
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
        
        if (array_key_exists('name', $options)) {
            $this->setName($options['name']);
        }
        
        parent::__construct($array, $options);
        $this->setFlags(self::ARRAY_AS_PROPS);
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