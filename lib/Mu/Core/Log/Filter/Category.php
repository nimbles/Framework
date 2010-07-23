<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Filter;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Category extends FilterAbstract {
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
