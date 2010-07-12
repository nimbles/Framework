<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Core
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Log extends Mixin\MixinAbstract {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Plugin\Pluginable' => array(
			'types' => array(
				'writers' => array('abstract' => 'Mu\Core\Log\Writer\WriterAbstract')
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

		foreach($this->writers as $writer) {
			$writer->write($entry);
		}
	}
}