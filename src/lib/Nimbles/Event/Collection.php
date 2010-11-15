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
 * @package    Nimbles-Event
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Event;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @uses       \Nimbles\Event\Event
 */
class Collection extends \Nimbles\Core\Collection {
    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $options = array_merge(
            (null === $options) ? array() : $options,
            array(
                'type' => 'Nimbles\Event\Event',
                'indexType' => static::INDEX_ASSOCITIVE,
                'readonly' => false
            )
        );

        parent::__construct($array, $options);
    }

    /**
     * Connects a callable to an event
     * @param string|\Nimbles\Event\Event|\Nimbles\Event\Event\SelfConnectInterface $event
     * @param mixed                                                                 $callable
     * @return void
     */
    public function connect($event, $callable = null) {
        if ($event instanceof SelfConnectInterface) { // self connect the object
            if (!is_array($connections = $event->getConnections())) {
                throw new Exception\InvalidConnections('Nimbles\Core\Event\SelfConnectInterface::getConnections should return an array');
            }

            foreach ($connections as $event => $callable) {
                $this->connect($event, $callable);
            }
            return;
        }

        $name = ($event instanceof Event) ? $event->getName() : $event;

        if (!is_callable($callable) && is_array($callable)) { // if we have an array of callables, add each
            foreach ($callable as $call) {
                $this->connect($name, $call);
            }
            return;
        }

        if (!$this->offsetExists($name)) {
            $this[$name] = new Event(array($callable), array('name' => $name));
        } else {
            $this[$name][] = $callable;
        }
    }

    /**
     * Fires the event, calling all handlers
     * @param string $name
     * @return void
     */
    public function fireEvent($name) {
        $args = func_get_args();
        array_shift($args);

        if ($this->offsetExists($name)) {
            call_user_func_array(array($this[$name], 'fire'), $args);
        }
    }

    /**
     * Fires the event, calling all handlers until one returns true
     * @param string $name
     * @return void
     */
    public function fireEventUntil($name) {
        $args = func_get_args();
        array_shift($args);

        if ($this->offsetExists($name)) {
            call_user_func_array(array($this[$name], 'fireUntil'), $args);
        }
    }
}