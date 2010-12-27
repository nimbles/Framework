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
     * Array of overrides which have been applied
     * @var array
     */
    protected static $_overrides = array();
    
    /**
     * Asserts that the collection is of a given type
     *
     * @param $type
     * @param $array
     * @param $message
     */
    public function assertCollection($type, $array, $message = '') {
        if ($array instanceof \ArrayObject) {
            $array = $array->getIterator();
        }
        
        $this->assertContainsOnly($type, $array, $message);
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
    
    /**
     * Override runBare to define functions
     * @return void
     */
    public function runBare() {
        $annotations = $this->getAnnotations();
        
        if (array_key_exists('override', $annotations['method'])) {
            if (!extension_loaded('runkit')) {
                throw new \PHPUnit_Framework_SkippedTestError('Cannot apply override without the runkit extension');                
            }
            
            foreach ($annotations['method']['override'] as $override) {
                $this->applyOverride($override);
            }
        }
        
        return parent::runBare();
    }
    
    /**
     * Applies the override
     * @param string $override
     * @return void
     */
    public function applyOverride($override) {
        if (!in_array($override, static::$_overrides) && method_exists($this, $method = 'override' . ucfirst($override))) {
            $this->$method();
            static::$_overrides[] = $override;
        }
    }
    
    /**
     * Replaces native php function with code for testing
     * @param string $name
     * @param string $args The new argument list
     * @param string $code The code to be eval'd
     * @return void
     * 
     * @throws \PHPUnit_Framework_SkippedTestError
     */
    public static function replaceFunction($name, $args, $code, $copy = null) {
        if (!function_exists($name)) {
            throw new \PHPUnit_Framework_SkippedTestError('Function does not exist: ' . $name);
        } 
        
        if (!extension_loaded('runkit')) {
            throw new \PHPUnit_Framework_SkippedTestError('Runkit extension is not loaded');
        }
        
        if (null !== $copy) {
            \runkit_function_copy($name, $copy);
        }
        
        \runkit_function_redefine($name, $args, $code);
    }
}
