<?php
namespace Mu\Log;

/**
 * @category Mu
 * @package Mu\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Writer extends \Mu\Mixin {
	/**
	 * Implements for this mixin
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Plugin\Pluginable' => array(
			'types' => array(
				'filters' => array(
					'abstract' => 'Mu\Log\Filter',
				)
			),
		),
		'Mu\Config\Options' => array(
			'formatter' => 'simple',
			'separator' => "\n"
		)
	);
	
	/**
	 * The formatter used by this writer
	 * @var \Mu\Log\Formatter
	 */
	protected $_formatter;
	
	/**
	 * Gets the formatter to be used by this writer
	 * @return \Mu\Log\Formatter
	 */
	public function getFormatterObject() {
		if (null === $this->_formatter) {
			$this->_formatter = Formatter::factory($this->getOption('formatter'));
		}
		return $this->_formatter;	
	}
	
	/**
	 * Class construct
	 * @param array $options
	 * @return void
	 */
	public function __construct(array $options = array()) {
		parent::__construct();
		$this->setOptions($options);
	}
	
	/**
	 * Method which writes the log entry
	 * @param \Mu\Log\Entry $entry
	 */
	public function write(Entry $entry) {
		foreach ($this->plugins->filters as $filter) {
			if ($filter->filter($entry)) { // stop if the filter removes the log entry from being written
				return;
			}
		}
		
		$this->_write($this->getFormatterObject()->format($entry));
	}
	
	/**
	 * Abstract method to write the formatted entry
	 * @param string $formattedEntry
	 * @return bool indicates that the entry could not be written
	 */
	abstract protected function _write($formattedEntry);
}