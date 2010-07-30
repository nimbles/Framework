<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  \Mu\Core
 * @package   \Mu\Core\Loader
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Loader
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Loader {
    /**
     * Registers the autoloader
     * @return void
     */
    static public function register() {
        $includepaths = explode(PATH_SEPARATOR, get_include_path());

        if (!in_array(MU_PATH, $includepaths)) {
            set_include_path(
                MU_PATH . PATH_SEPARATOR .
                get_include_path()
            );
        }

        spl_autoload_register(__NAMESPACE__ . '\Loader::autoload');
    }

    /**
     * The autoloader for Mu classes
     * @param string $class
     * @return void
     */
    static public function autoload($class) {
        // only need to replace back slashes with forward slashes since php 5.3
        $file = str_replace('\\', '/', $class) . '.php';
        if (self::_fileExists($file)) {
            require_once $file;
        }
    }

    /**
     * Checks if a file exists on include path
     * @param string $file
     * @return bool
     */
    static protected function _fileExists($file) {
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
