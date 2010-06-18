<?php
namespace Mu\Core\Log\Filter;

/**
 * @category Mu
 * @package Mu\Core\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Category extends \Mu\Core\Log\Filter {
	/**
	 * Filters based on category
	 * @param \Mu\Core\Log\Entry $entry
	 */
	public function apply(\Mu\Core\Log\Entry $entry) {
		if (!is_string($this->getOption('category'))) {
			throw new Exception\InvalidCategory('Category must be specified');
		}
		
		return ($entry->getOption('category') === $this->getOption('category'));
	}
}