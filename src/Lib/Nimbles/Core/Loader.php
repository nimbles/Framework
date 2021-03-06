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
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Loader {
    /**
     * Registers the autoloader
     * @return void
     */
    public static function register() {
        $includepaths = explode(PATH_SEPARATOR, get_include_path());

        if (!in_array(NIMBLES_PATH, $includepaths)) {
            set_include_path(
                NIMBLES_PATH . PATH_SEPARATOR .
                get_include_path()
            );
        }
        
        spl_autoload_extensions('.php');
        
        /**
         * Add support for lower case build mode
         */
        if ('loader.php' === basename(__FILE__)) {
            spl_autoload_register('Nimbles\Core\Loader::autoload', false, true);
            spl_autoload_register('spl_autoload', false, true);
        } else if (function_exists('spl_autoload_case_sensitive')) {
            spl_autoload_case_sensitive(true);
            spl_autoload_register('spl_autoload', false, true);
        } else {
            spl_autoload_register('Nimbles\Core\Loader::autoload', false, true);
        }
    }

    /**
     * The autoloader for Nimbles classes
     * @param string $class
     * @return bool
     */
    public static function autoload($class) {
        $file = str_replace('\\', '/', $class) . '.php';
        if (static::fileExists($file)) {
            require_once $file;
            return true;
        }

        return false;
    }

    /**
     * Checks if a file exists on include path
     * @param string $file
     * @return bool
     */
    public static function fileExists($file) {
        return false !== stream_resolve_include_path($file);
    }
}
