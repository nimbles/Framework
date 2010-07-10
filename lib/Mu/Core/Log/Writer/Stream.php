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
 * @package   Mu\Core\Log\Writer\Stream
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Writer;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Writer\Stream
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Stream extends \Mu\Core\Log\Writer {
	/**
	 * Stream resource
	 * @var resource
	 */
	protected $_stream;

	/**
	 * Writes an entry to a stream
	 * @param string $entry
	 * @return void
	 * @throws Mu\Core\Log\Writer\Exception\MissingStreamOption
	 */
	protected function _write($entry) {
		if (null === $this->_stream) {
			if (null === ($this->_stream = $this->getOption('stream'))) {
				throw new Exception\MissingStreamOption('Stream writer must be given a stream option to write to');
			}

			if (!is_resource($this->_stream)) {
				$this->_stream = fopen($this->_stream, 'a+');
			}
		}

		fwrite($this->_stream, $entry . $this->getOption('separator'));
	}

	/**
	 * Closes the stream connection
	 * @return void
	 */
	public function __destruct() {
		try {
			if (is_resource($this->_stream)) {
				@fclose($this->_stream); // surpress warning for destruct
			}
		} catch (\Exception $ex) {} // desctruct cannot throw exceptions
	}
}