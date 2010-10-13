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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Config;

use Nimbles\Core\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Config
 * @uses       \Nimbles\Core\Config\File
 * @uses       \Nimbles\Core\Config\Exception\MissingConfigDirectory
 */
class Directory extends File {
    /**
     * Class construct
     * @param string $directory   The directory containing the config files
     * @param string $environment The environment of which to load the config data
     * @return void
     */
    public function __construct($directory, $environment) {
        $this->_config = new Config();
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
