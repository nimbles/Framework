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
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

use PHPUnit_Framework_TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \PHPUnit_Framework_TestCase
 */
class TestCase extends PHPUnit_Framework_TestCase {
    /**
     * Asserts that the collection is of a given type
     *
     * @param $type
     * @param $array
     * @param $message
     */
    public function assertCollection($type, $array, $message = '') {
        $this->assertThat(
            $array,
            $this->logicalOr(
                new \PHPUnit_Framework_Constraint_IsType('array'),
                new \PHPUnit_Framework_Constraint_IsInstanceOf('\ArrayObject')
            ),
            'Array must be an array or an instance of ArrayObject'
        );

        foreach ($array as $value) {
            $this->assertType($type, $value, $message);
        }
    }
    
    /**
     * Asserts that the object has the given method
     * 
     * @param object $object
     * @param string $method
     * @param string $message
     */
    public function assertHasMethod($object, $method, $message = '') {
        $this->assertThat(
            method_exists($object, $method),
            self::isTrue(),
            '' === $message ? get_class($object) . ' does not have method ' . $method : $message
        );
    }
    
	/**
     * Asserts that the object has the given method
     * 
     * @param object $object
     * @param string $method
     * @param string $message
     */
    public function assertNotHasMethod($object, $method, $message = '') {
        $this->assertThat(
            method_exists($object, $method),
            self::isFalse(),
            '' === $message ? get_class($object) . ' has method ' . $method : $message
        );
    }
}
