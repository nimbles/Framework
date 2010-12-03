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
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Pattern;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Pattern\Multiton
 */
class BasicMultiton {
    protected $_value;

    public function __construct($value = '') {
        $this->_value = $value;
    }

    public function getValue() {
        return $this->_value;
    }
}
