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
    static public function register() {
        $includepaths = explode(PATH_SEPARATOR, get_include_path());

        if (!in_array(NIMBLES_PATH, $includepaths)) {
            set_include_path(
                NIMBLES_PATH . PATH_SEPARATOR .
                get_include_path()
            );
        }

        spl_autoload_register('Nimbles\Core\Loader::autoload');
    }

    /**
     * The autoloader for Nimbles classes
     * @param string $class
     * @return void
     */
    static public function autoload($class) {
        // only need to replace back slashes with forward slashes since php 5.3
        $file = str_replace('\\', '/', $class) . '.php';
        if (static::fileExists($file)) {
            require_once $file;
        }
    }

    /**
     * Checks if a file exists on include path
     * @param string $file
     * @return bool
     */
    static public function fileExists($file) {
        if (false !== realpath($file)) {
            return true;
        }

        $include_paths = explode(PATH_SEPARATOR, get_include_path());
        foreach ($include_paths as $include_path) {
            if (false !== realpath($include_path . '/' . $file)) {
                return true;
            }
        }
        return false;
    }
}
