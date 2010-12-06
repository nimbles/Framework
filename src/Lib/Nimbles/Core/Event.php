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
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @uses       \Nimbles\Core\Event\Exception\InvalidName
 */
class Event extends \Nimbles\Core\Collection {
    /**
     * The event name
     * @var string
     */
    protected $_name;

    /**
     * Gets the event name
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Sets the event name
     * @param string $name
     * @return \Nimbles\Core\Event
     * @throws \Nimbles\Core\Event\Exception\InvalidName
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new Event\Exception\InvalidName('Event name must be a string: ' . $name);
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
                'type' => 'callable',
                'indexType' => static::INDEX_NUMERIC,
                'readonly' => false
            )
        );

        if (array_key_exists('name', $options)) {
            $this->setName($options['name']);
        }

        parent::__construct($array, $options);
    }

    /**
     * Fires the event, calling all handlers
     * @return void
     */
    public function fire() {
        $args = func_get_args();
        array_unshift($args, $this);

        foreach ($this as $callable) {
            call_user_func_array($callable, $args);
        }
    }

    /**
     * Fires the event, calling all handlers until one returns true
     */
    public function fireUntil() {
        $args = func_get_args();
        array_unshift($args, $this);

        foreach ($this as $callable) {
            if (call_user_func_array($callable, $args)) {
                return;
            }
        }
    }
}