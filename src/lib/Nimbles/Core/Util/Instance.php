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
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Core\Util;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Instance {
    /**
     * Gets an instance of the given class passing the
     * provided arguments into constructor.
     * 
     * This function only exists to assist dynamic loading of classes
     * such as dependency injection. The function does not check for the
     * correct number of constructor arguments.
     * 
     * @param string $class
     * @param array|null $args
     */
    public static function getInstance($class, array $args = null) {
        if ((null === $args) || (0 === count($args))) {
            return new $class();
        }
        
        $ref = new \ReflectionClass($class);
        return $ref->newInstanceArgs($args);
    }
}