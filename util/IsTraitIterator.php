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
 * @package    Nimbles-Build
 * @subpackage IsTraitIteractor
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Build;

/**
 * @category   Nimbles
 * @package    Nimbles-Build
 * @subpackage IsTraitIteractor
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \FilterIterator
 */
class IsTraitIteractor extends \FilterIterator {
    /**
     * The namespace the trait should belong to
     * @var string
     */
    protected $_namespace;
    
    /**
     * The name of the trait that is being loaded
     * @var string
     */
    protected $_trait;
    
    /**
     * Class construct
     * @param \Iterator $iterator
     * @param string $trait
     */
    public function __construct($iterator, $namespace, $trait) {
        parent::__construct($iterator);
        $this->_namespace = $namespace;
        $this->_trait = $trait;
    }
    
    /**
     * (non-PHPdoc)
     * @see FilterIterator::accept()
     */
    public function accept() {
        $file = $this->getInnerIterator()->current();
        
        if (is_array($file)) {
            $file = $file[0];
        }

        if (!file_exists($file)) {
            return false;
        }
        
        $contents = file_get_contents($file);
        
        if (0 === preg_match('/namespace\s+' . preg_quote($this->_namespace, '/') . ';/', $contents)) {    
            return false;
        }
        
        if (0 === preg_match('/trait\s+' . preg_quote($this->_trait, '/') . '/', $contents)) {
            return false;
        }
        
        return true;
    }
}