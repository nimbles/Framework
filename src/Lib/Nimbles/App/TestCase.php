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
     * Flag to set if functions have been defined
     * @var bool
     */
    protected static $_functionsDefined = false;
    
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
        if (!static::$_functionsDefined) {
            static::_defineFunctions();    
        }
        
        static::$_headers = array();
        
        return parent::runBare();
    }
    
    /**
     * Define functions to help running the tests
     * @return void
     */
    protected static function _defineFunctions() {
        static::replaceFunction(
        	'header',
        	'$header, $replace = true, $code = null',
            '\Nimbles\App\TestCase::header($header, $replace, $code);'
        );
        
        static::$_functionsDefined = true;
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
        
        list($key, $value) = explode(':', $header, 2);
        if ($replace || !array_key_exists($key, static::$_headers)) {
            static::$_headers[$key] = array($value);
        } else {
            static::$_headers[$key][] = $value;
        }
        
        static::$_statusCode = $code;
    }
}