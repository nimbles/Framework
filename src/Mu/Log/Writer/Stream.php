<?php
namespace Mu\Log\Writer;

/**
 * @category Mu
 * @package Mu\Log\Writer\Stream
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Stream extends \Mu\Log\Writer {
	protected $_stream;
	
	protected function _write($entry) {
		if (null === $this->_stream) {
			if (null === ($this->_stream = $this->getOption('stream'))) {
				throw new Exception\MissingPathOption('Stream writer must be given a stream option to write to');
			}
			
			if (!is_resource($this->_stream)) {
				$this->_stream = fopen($this->_stream, 'a+');
			}
		}
		
		fwrite($this->_stream, $entry . $this->getOption('separator'));
	}
	
	public function __desctruct() {
		try {
			if (is_resource($this->_stream)) {
				@fclose($this->_stream); // surpress warning for destruct
			}
		} catch (\Exception $ex) {} // desctruct cannot throw exceptions
	}
}