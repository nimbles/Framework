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
 * @category  Mu\Core
 * @package   Mu\Core\Config\Directory
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Config\Directory
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Config\File
 * @uses      \Mu\Core\Config\Exception\MissingConfigDirectory
 */
class Directory extends File {
    /**
     * Class construct
     * @param string $directory   The directory containing the config files
     * @param string $environment The environment of which to load the config data
     * @return void
     */
    public function __construct($directory, $environment) {
        $this->_parsedConfig = array();
        $this->_readConfigFiles($directory, $environment);
    }

    /**
     * Reads the config files from a given directory
     * @param string $directory
     * @param string $environment
     * @return void
     */
    protected function _readConfigFiles($directory, $environment) {
        if (!is_dir($directory)) {
            throw new Exception\MissingConfigDirectory('Cannot find config directory : ' . $directory);
        }

        foreach (scandir($directory) as $filename) {
            if (!is_dir($directory . '/' . $filename)) { // skip . and ..
                $this->_readConfigFile($directory . '/' . $filename, $environment);
            }
        }
    }
}
