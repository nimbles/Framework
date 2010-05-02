<?php
namespace Mu\Log\Writer;

/**
 * @category Mu
 * @package Mu\Log\Writer\Stream
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Stream extends \Mu\Log\Writer {
	/**
	 * Stream resource
	 * @var resource
	 */
	protected $_stream;
	
	/**
	 * Writes an to a stream
	 * @param string $entry
	 * @return void
	 * @throws Mu\Log\Writer\Exception\MissingStreamOption
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
	public function __desctruct() {
		try {
			if (is_resource($this->_stream)) {
				@fclose($this->_stream); // surpress warning for destruct
			}
		} catch (\Exception $ex) {} // desctruct cannot throw exceptions
	}
}