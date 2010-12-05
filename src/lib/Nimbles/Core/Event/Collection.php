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
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Event;

use Nimbles\Core,
    Nimbles\Core\Event;

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
 * @uses       \Nimbles\Core\Event
 */
class Collection extends Core\Collection {
    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $options = array_merge(
            (null === $options) ? array() : $options,
            array(
                'type' => 'Nimbles\Core\Event',
                'indexType' => static::INDEX_ASSOCITIVE,
                'readonly' => false
            )
        );

        parent::__construct($array, $options);
        $this->setFlags(self::ARRAY_AS_PROPS);
    }

    /**
     * Connects a callable to an event
     * @param string|\Nimbles\Core\Event|\Nimbles\Core\Event\SelfConnectInterface $event
     * @param mixed                                                                 $callable
     * @return void
     * @throws \Nimbles\Core\Event\Exception\InvalidConnections
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
    
	/**
     * Factory method for creating events
     * @param string|int                        $index
     * @param string|array|\Nimbles\Core\Event $event
     * @return \Nimbles\Core\Event|null
     */
    public static function factory($index, $event) {
        if (is_string($event)) {
            $event = new Event(null, array(
                'name' => $event
            ));
        } else if (is_array($event)) { // treat as options
            $event = new Event($event);
        }
        
        if ($event instanceof Event) {
            $event->setName($index); // keep index and name in sync
            return $event;
        }
        
        return null;
    }
}