<?php
namespace Mu\Core\Log;

/**
 * @category Mu\Core
 * @package Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Filter extends \Mu\Core\Mixin {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array('Mu\Core\Config\Options');
	
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
	 * @param \Mu\Core\Log\Entry $entry
	 */
	abstract public function apply(Entry $entry);
}