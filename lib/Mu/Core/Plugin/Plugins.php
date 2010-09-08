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
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Plugin;

use Mu\Core\Plugin,
    Mu\Core\Mixin\MixinAbstract,
    Mu\Core\ArrayObject,
    Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Core\ArrayObject
 *
 * @uses       \Mu\Core\Config
 * @uses       \Mu\Core\Plugin
 */
class Plugins extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * Plugin types, lazy loaded
     * @var \ArrayObject
     */
    protected $_types;

    /**
     * Gets a plugin type
     * @param string $type
     * @return \Mu\Core\Plugin|null
     */
    public function getType($type) {
        if (!($this->_types instanceof ArrayObject)) {
            $this->_types = new ArrayObject();
        }

        if ($this->_types->offsetExists($type)) {
            return $this->_types[$type];
        }

        $types = $this->getOption('types');

        if (!($types instanceof Config)) {
            $types = new Config($types);
        }

        foreach ($types as $key => $options) {
            if (is_numeric($key)) {
                $key = $options;
                $options = null;
            }

            if ($type === $key) {
                $this->_types[$type] = new Plugin($options);
                return $this->_types[$type];
            }
        }

        return null;
    }

    /**
     * Checks if the plugin has the types
     * @param string $type
     * @return bool
     */
    public function hasType($type) {
        return (null !== $this->getType($type));
    }

    /**
     * Magic __get to access types
     * @param string $type
     * @return \Mu\Core\Plugin|null
     */
    public function __get($type) {
        return $this->getType($type);
    }

    /**
     * Magic __isset to check if a type exists
     * @param string $type
     * @return bool
     */
    public function __isset($type) {
        return $this->hasType($type);
    }

    /**
     * Class construct
     * @param array|\Mu\Core\Config $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Notifies all plugin types
     * @param object|null $object
     * @return void
     */
    public function notify($object = null) {
        $types = $this->getOption('types');

        if (!($types instanceof Config)) {
            $types = new Config($types);
        }

        foreach ($types as $key => $options) {
            if (is_numeric($key)) {
                $key = $options;
            }

            $this->{$key}->notify($object);
        }
    }
}
