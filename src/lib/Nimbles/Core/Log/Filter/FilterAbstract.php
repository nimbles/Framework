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

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Log\Entry
 */
abstract class FilterAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * Class construct
     * @param array|\ArrayObject $options
     * @return void
     */
    public function __construct($options) {
        $this->setOptions($options);
    }

    /**
     * Filters the entry
     * @param \Nimbles\Core\Log\Entry $entry
     * @return bool
     */
    abstract public function apply(Entry $entry);
}
