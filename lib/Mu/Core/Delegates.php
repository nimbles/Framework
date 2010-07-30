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
 * @category  \Mu\Core
 * @package   \Mu\Core\Delegates
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Delegatable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Delegates extends \Mu\Core\Mixin\MixinAbstract {
    /**
     * Delegates implements options
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');

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
     * @return \Mu\Core\Delegates
     * @throws \Mu\Core\Delegates\Exception\InvalidDelegateName
     * @throws \Mu\Core\Delegates\Exception\InvalidDelegate
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
     * @return \Mu\Core\Delegates
     * @throws \Mu\Core\Delegates\Exception\DelegateCreationNotAllowed
     * @throws \Mu\Core\Delegates\Exception\InvalidDelegateName
     * @throws \Mu\Core\Delegates\Exception\InvalidDelegate
     */
    public function setDelegate($name, $delegate) {
        if (!$this->hasDelegate($name)) {
            throw new Delegates\Exception\DelegateCreationNotAllowed('Delegate name can only be declared in options');
        }

        if (!is_callable($delegate)) {
            throw new Delegates\Exception\InvalidDelegate('Delegate must be callable');
        }

        $this->_delegates[$name] = $delegate;
    }

    /**
     * Class construct
     * @param array|\Mu\Core\Config $options
     * @return void
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }
}