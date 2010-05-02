<?php
namespace Mu\Log\Filter;

/**
 * @category Mu
 * @package Mu\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Category extends \Mu\Log\Filter {
	/**
	 * Filters based on category
	 * @param \Mu\Log\Entry $entry
	 */
	public function filter(\Mu\Log\Entry $entry) {
		if (!is_string($this->getOption('category'))) {
			throw new Exception\InvalidCategory('Category must be specified');
		}
		
		return ($entry->getCategory() === $this->getOption('category'));
	}
}