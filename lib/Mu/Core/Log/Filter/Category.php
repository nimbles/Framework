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
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Filter;

use Mu\Core\Log\Entry;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Filter\Category
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Log\Filter\FilterAbstract
 * @uses      \Mu\Core\Log\Entry
 * @uses      \Mu\Core\Log\Filter\Exception\InvalidCategory
 */
class Category extends FilterAbstract {
    /**
     * Filters based on category
     * @param \Mu\Core\Log\Entry $entry
     * @return bool
     */
    public function apply(Entry $entry) {
        if (!is_string($this->getOption('category'))) {
            throw new Exception\InvalidCategory('Category must be specified');
        }

        return ($entry->getOption('category') === $this->getOption('category'));
    }
}
