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
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

use Nimbles\Core\Mixin\MixinAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Config\Options
 *
 * @uses       \ArrayObject
 *
 * @uses       \Nimbles\Core\Delegates\Exception\InvalidDelegate
 * @uses       \Nimbles\Core\Delegates\Exception\InvalidDelegateName
 * @uses       \Nimbles\Core\Delegates\Exception\DelegateCreationNotAllowed
 * @uses       \Nimbles\Core\Config
 */
class Delegates extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * The array of delegates
     * @var \ArrayObject
     */
    protected $_delegates;

    /**
     * Gets the array of delegates
     * @return \ArrayObject
     */
    public function getDelegates() {
        if (!($this->_delegates instanceof \ArrayObject)) {
            $this->_delegates = new \ArrayObject();
        }

        return $this->_delegates;
    }

    /**
     * Sets the array of delegates
     * @param array $delegates
     * @return \Nimbles\Core\Delegates
     * @throws \Nimbles\Core\Delegates\Exception\InvalidDelegateName
     * @throws \Nimbles\Core\Delegates\Exception\InvalidDelegate
     */
    public function setDelegates(array $delegates) {
        if (!($this->_delegates instanceof \ArrayObject)) {
            $this->_delegates = new \ArrayObject();
        }

        foreach ($delegates as $name => $delegate) {
            if (!is_string($name) || is_numeric($name)) {
                throw new Delegates\Exception\InvalidDelegateName('Delegate name must be a string and non numeric');
            }

            if (!is_callable($delegate)) {
                throw new Delegates\Exception\InvalidDelegate('Delegate ' . $name . ' must be callable');
            }

            $this->_delegates[$name] = $delegate;
        }

        return $this;
    }

    /**
     * Checks if the delegate has been declared
     * @param string $name
     * @return bool
     */
    public function hasDelegate($name) {
        return $this->getDelegates()->offsetExists($name);
    }

    /**
     * Gets a delegate by name
     * @param string $name
     * @return string|array|\Closure|null
     */
    public function getDelegate($name) {
        if ($this->hasDelegate($name)) {
            return $this->getDelegates()->offsetGet($name);
        }

        return null;
    }

    /**
     * Sets a delegate
     * @param string $name
     * @param string|array|\Closure $delegate
     * @return \Nimbles\Core\Delegates
     * @throws \Nimbles\Core\Delegates\Exception\DelegateCreationNotAllowed
     * @throws \Nimbles\Core\Delegates\Exception\InvalidDelegateName
     * @throws \Nimbles\Core\Delegates\Exception\InvalidDelegate
     */
    public function setDelegate($name, $delegate) {
        if (!$this->hasDelegate($name)) {
            throw new Delegates\Exception\DelegateCreationNotAllowed('Delegate name can only be declared in options');
        }

        if (!is_callable($delegate)) {
            throw new Delegates\Exception\InvalidDelegate('Cannot assign new delegate for: ' . $name . '; delegate must be callable');
        }

        $this->_delegates[$name] = $delegate;
    }

    /**
     * Class construct
     * @param array|\Nimbles\Core\Config $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }
}