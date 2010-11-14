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
 * @package    Nimbles-Event
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Event;

use Nimbles\Event\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
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
	 * The collection of events
	 * @var \Nimbles\Event\Collection
	 */
	protected $_events;
	
	/**
	 * Gets the event object or the collection if no event key is specified
	 * @param string|null $event
	 * @return \Nimbles\Event\Event|\Nimbles\Event\Collection
	 */
	public function getEvent($event = null) {
		if (null === $this->_events) {
			$this->_events = new \Nimbles\Event\Collection();
		}
		
		if (null === $event) {
			return $this->_events;
		}
		
		return $this->_events->offsetExists($event) ? $this->_events[$event] : null;
	}
	
	/**
     * Connects a callable to an event.
     * 
     * If an instanceof \Nimbles\Event\Event\SelfConnectInterface then this will automatically
     * connect to multiple events
     *  
     * @param string|\Nimbles\Event\Event|\Nimbles\Event\Event\SelfConnectInterface $event
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
		return call_user_func_array(array($this->getEvent(), 'fireEvent'), $args);
	}
	
	/**
     * Fires the event, calling all handlers until one returns true
     * @param string $name
     * @return void
     */
	public function fireEventUntil($name) {
		$args = func_get_args();
		return call_user_func_array(array($this->getEvent(), 'fireEventUntil'), $args);
	}
}