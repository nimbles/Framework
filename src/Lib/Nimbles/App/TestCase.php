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
 * @package    Nimbles-App
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App;

use Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 */
class TestCase extends Core\TestCase {    
    /**
     * The array of headers for this case
     * @var array
     */
    protected static $_headers;
    
    /**
     * Flag to indicate that the headers have been sent
     * @var bool
     */
    protected static $_headersSent = false;
    
    /**
     * The status code
     * @var int
     */
    protected static $_statusCode = 200;

    /**
     * Override runBare to define functions
     * @return void
     */
    public function runBare() {
        static::$_headers = array();
        static::$_headersSent = false;
        static::$_statusCode = 200;
        
        return parent::runBare();
    }
    
    /**
     * Define header functions
     * @return void
     */
    protected static function overrideHeader() {
        static::replaceFunction(
        	'header',
        	'$header, $replace = true, $code = null',
            '\Nimbles\App\TestCase::header($header, $replace, $code);'
        );
        
        static::replaceFunction(
        	'header_remove',
        	'$name = null',
            '\Nimbles\App\TestCase::header_remove($name);'
        );
        
        static::replaceFunction(
            'headers_list',
            '',
            'return \Nimbles\App\TestCase::headers_list();'
        );
        
        static::replaceFunction(
            'headers_sent',
            '',
            'return \Nimbles\App\TestCase::headers_sent();'
        );
    }
    
    /**
     * Static method for replacing the native header function
     * @param string $header
     * @param bool $replace
     * @param int|null $code
     * @return void
     */
    public static function header($header, $replace = true, $code = 200) {
        if (false == strpos($header, ':')) {
            return;
        }
        
        list($key, $value) = array_map('trim', explode(':', $header, 2));
        
        if (false !== strpos($value, ',')) {
            $values = array_map('trim', explode(',', $value));
        } else {
            $values = array($value);
        }
       
        if ($replace || !array_key_exists($key, static::$_headers)) {
            static::$_headers[$key] = $values;
        } else {
            static::$_headers[$key] += $values;
        }
        
        static::$_statusCode = $code;
    }
    
    /**
     * Removes a header by name
     * @param string $name
     * @return void
     */
    public static function header_remove($name = null) {
        if (null === $name) {
            static::$_headers = array();
        }
        
        if (array_key_exists($name, static::$_headers)) {
            if (1 < count(static::$_headers[$name])) {
                array_shift(static::$_headers[$name]);
            } else {
                unset(static::$_headers[$name]);
            }
        }
    }
    
    /**
     * Gets the headers that have been or will be sent
     * @return array
     */
    public static function headers_list() {
        $list = array();
        
        foreach (static::$_headers as $header => $values) {
            foreach ($values as $value) {
                $list[] = sprintf('%d: %d', $header, $value);
            }
        }
        
        return $list;
    }
    
    /**
     * Gets the a flag to say if the headers have been sent
     * @return bool
     */
    public static function headers_sent() {
        return static::$_headersSent;
    }
    
    /**
     * Marks the headers as sent
     * @return void
     */
    public static function sendHeaders() {
        static::$_headersSent = true;
    }
    
    /**
     * Asserts that a header of the given name has the given value
     * @param string $name
     * @param string $value
     * @param string $message
     * @return void
     */
    public function assertHeaderEquals($name, $value, $message = '') {
        static::assertHeaderExists($name, $message);
        static::assertContains(
            $value,
            static::$_headers[$name],
            '' === $message ? 'Header ' . $name . ' does not contain value ' . $value : $message
        );
    }
    
    /**
     * Asserts that a header of the given name does not have the given value
     * @param string $name
     * @param string $value
     * @param string $message
     * @return void
     */
    public function assertHeaderNotEquals($name, $value, $message = '') {
        if (array_key_exists($name, static::$_headers)) {
            static::assertNotContains($value, static::$_headers[$name], $message);
        }
        $this->pass();
    }
    
    /**
     * Asserts that a header exists
     * @param string $name
     * @param string $message
     * @return void
     */
    public function assertHeaderExists($name, $message = '') {
        if (!array_key_exists($name, static::$_headers)) {
            $this->fail('Header ' . $name . ' does not exist');
        }
        
        static::assertArrayHasKey(
            $name,
            static::$_headers,
            '' === $message ? 'Header ' . $name . ' does not exist' : $message
        );
    }
    
    /**
     * Asserts that a header does not exist
     * @param string $name
     * @param string $message
     * @return void
     */
    public function assertHeaderNotExists($name, $message = '') {
        static::assertArrayNotHasKey($name, static::$_headers, $message);
    }
    
    /**
     * Asserts that the status code is of the given value
     * @param int $code
     * @param string $message
     * @return void
     */
    public function assertStatusCodeEquals($code, $message = '') {
        static::assertEquals($code, static::$_statusCode, $message);
    }
    
    /**
     * Asserts that the status code is not of the given value
     * @param int $code
     * @param string $message
     * @return void
     */
    public function assertStatusCodeNotEquals($code, $message = '') {
        static::assertNotEquals($code, static::$_statusCode, $message);
    }
}