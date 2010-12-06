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
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Optons
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Options
 */
class OptionsMock {
    protected $_bool;
    
    protected $_value;
    
    public function isBool($flag = null) {
        if (is_bool($flag)) {
            $this->_bool = $flag;
        }
        
        return $this->_bool;
    }
    
    public function getValue() {
        return $this->_value;
    }
    
    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }
    
    public function __construct($options = null) {
        $this->setOptions($options);
    }
}