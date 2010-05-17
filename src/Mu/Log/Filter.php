<?php
namespace Mu\Log;

/**
 * @category Mu
 * @package Mu\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Filter extends \Mu\Mixin {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array('Mu\Config\Options');
	
	/**
	 * Class construct
	 * @param array|\ArrayObject $options
	 */
	public function __construct($options) {
		parent::__construct();
		$this->setOptions($options);
	}
	
	/**
	 * Filters the entry
	 * @param \Mu\Log\Entry $entry
	 */
	abstract public function apply(Entry $entry);
}