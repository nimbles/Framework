<?php
namespace Mu\Core;

/**
 * @category Mu\Core
 * @package Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Log extends Mixin {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Plugin\Pluginable' => array(
			'types' => array(
				'writers' => array('abstract' => 'Mu\Core\Log\Writer')
			)
		)
	);

	/**
	 * Instance of Log
	 * @var \Mu\Core\Log
	 */
	static protected $_instance;

	/**
	 * Gets an instance of the Log
	 * @return \Mu\Core\Log
	 */
	static public function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new Log();
		}

		return self::$_instance;
	}

	/**
	 * Writes a log entry
	 * @param string|array|\Mu\Core\Log\Entry $entry
	 */
	public function write($entry) {
		if (!($entry instanceof Log\Entry)) {
			$entry = new Log\Entry($entry);
		}

		foreach($this->plugins->writers as $writer) {
			$writer->write($entry);
		}
	}
}