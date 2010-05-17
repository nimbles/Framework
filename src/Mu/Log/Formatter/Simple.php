<?php
namespace Mu\Log\Formatter;

/**
 * @category Mu
 * @package Mu\Log\Formatter\Simple
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Simple extends \Mu\Log\Formatter {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Config\Options' => array(
			'format' => '%timestamp% %pid% %level% - %category% - %message%'
		)
	);
	
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
	 * Formats the log entry according to the format option
	 * @param \Mu\Log\Entry $entry
	 * @return string
	 */
	public function format(\Mu\Log\Entry $entry) {
		$formatString = $this->getOption('format');
		
		preg_match_all('/%([^%]+)%/', $formatString, $matches);
		
		foreach ($matches[1] as $option) {
			$formattedOption = $this->getFormattedOption($entry, $option);
			$formatString = preg_replace('/%' . preg_quote($option, '/') . '%/', $formattedOption, $formatString);
		}
		
		return $formatString;
	}
}