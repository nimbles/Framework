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
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

use Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Config
 * @uses       \Mu\Core\Config\Exception\InvalidConfig
 */
class File {
    /**
     * The parsed config
     * @var Config
     */
    protected $_config;

    /**
     * Gets the config
     * @return \Mu\Core\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * Class construct
     * @param string $directory   The directory containing the config files
     * @param string $environment The environment of which to load the config data
     * @return void
     */
    public function __construct($file, $environment) {
        $this->_config = new Config();
        $this->_readConfigFile($file, $environment);
    }

    /**
     * Loads in the config file
     * @param string $file        The file containing the config array
     * @param string $environment The environment of which to load the config data
     * @return void
     */
    protected function _readConfigFile($file, $environment) {
        $section = substr(basename($file), 0, -4);
        $config = include $file;

        $this->_config[$section] = $this->_parseConfig($config, $environment);
    }

    /**
     * Parses the config
     * @param array  $config      The config to parse
     * @param string $environment The environment of which to load the config data
     * @return \Mu\Core\Config
     **/
    protected function _parseConfig(array $config, $environment) {
        $configCopy = new Config();

        foreach ($config as $section => &$subconfig) {
            if (preg_match('/^[a-z0-9]+ : [a-z0-9]+$/i', $section)) {
                list($section, $parent) = explode(' : ', $section);

                if (!isset($configCopy[$parent])) {
                    throw new Exception\InvalidConfig('Invalid config, parent config not defined: ' . $parent);
                }

                $configCopy[$section] = clone $configCopy[$parent];
                $configCopy[$section]->merge($subconfig);
            } else {
                $configCopy[$section] = $subconfig;
            }
        }

        if (isset($configCopy[$environment])) {
            return $configCopy[$environment];
        }

        // return first value, no match to environment found
        return reset($configCopy);
    }
}
