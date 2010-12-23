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

namespace Nimbles\Core\Event;

use Nimbles\Core\Event\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Event\Collection
 * @uses       \Nimbles\Event\Exception\InvalidName
 */
trait Events {
	/**
	 * Gets the event object or the collection if no event key is specified
	 * @param string|null $event
	 * @return \Nimbles\Core\Event|\Nimbles\Core\Event\Collection
	 */
	public function getEvent($event = null) {
		if (!isset($this->events)) {
			$this->events = new \Nimbles\Core\Event\Collection();
		} else if (!($this->events instanceof \Nimbles\Core\Event\Collection)) {
		    throw new \Nimbles\Core\Event\Exception\InvalidInstance('events property is not an instance of Nimbles\Event\Collection');
		}

		if (null === $event) {
			return $this->events;
		}

		return $this->events->offsetExists($event) ? $this->events[$event] : null;
	}

	/**
     * Connects a callable to an event.
     *
     * If an instanceof Nimbles\Core\Event\SelfConnectInterface then this will automatically
     * connect to multiple events
     *
     * @param string|\Nimbles\Core\Event|\Nimbles\Core\Event\SelfConnectInterface $event
     * @param mixed                                                                 $callable
     * @return void
     */
	public function connect($event, $callable = null) {
		return $this->getEvent()->connect($event, $callable);
	}

	/**
     * Fires the event, calling all handlers
     * @param string $name
     * @return void
     */
	public function fireEvent($name) {
		$args = func_get_args();
		
		if (null !== ($event = $this->getEvent($name))) {
		    return call_user_func_array(array($event, 'fire'), array_slice($args, 1));
		}
	}

	/**
     * Fires the event, calling all handlers until one returns true
     * @param string $name
     * @return void
     */
	public function fireEventUntil($name) {
	    $args = func_get_args();
	    
	    if (null !== ($event = $this->getEvent($name))) {
		    return call_user_func_array(array($event, 'fireUntil'), array_slice($args, 1));
	    }
	}
}