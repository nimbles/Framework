<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Log\Filter;

use Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Log\Filter\FilterAbstract
 * @uses       \Nimbles\Core\Log\Entry
 * @uses       \Nimbles\Core\Log\Filter\Exception\InvalidCategory
 */
class Category extends FilterAbstract {
    /**
     * Filters based on category
     * @param \Nimbles\Core\Log\Entry $entry
     * @return bool
     */
    public function apply(Entry $entry) {
        if (!is_string($this->getOption('category'))) {
            throw new Exception\InvalidCategory('Category must be specified');
        }

        return ($entry->getOption('category') === $this->getOption('category'));
    }
}
