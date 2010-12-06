<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Config\File;

use Nimbles\App\Config,
    Nimbles\App\Config\File\Exception;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Config\File\FileAbstract
 *
 * @uses       \Nimbles\App\Config
 * @uses       \Nimbles\App\Config\File\Exception\InvalidFile
 */
class Yaml extends FileAbstract {
    /**
     * Parses the file
     * @param string $section
     * @return \Nimbles\App\Config
     * @throws \Nimbles\App\Config\File\Exception\InvalidFormat
     */
    public function parse($section = null) {
        // @codeCoverageIgnoreStart
        if (!extension_loaded('yaml')) {
            throw new Exception\InvalidFormat('Cannot parse file, yaml extension not loaded');
        }
        // @codeCoverageIgnoreEnd
        
        $data = yaml_parse_file($this->getFile(), -1);
        
        /*
         *  when getting all docs, yaml_parse_file returns a numerical array
         *  containing each document, so for config, we need to get the first
         *  element in each
         */
        $configData = array();
        foreach ($data as $index => $config) {
            if (!is_array($config)) {
                throw new Exception\InvalidFormat('Invalid file contents, must result in an associtive array');
            }
            reset($config);
            $configData[key($config)] = current($config);
        }
        
        return $this->getSection($configData, $section);
    }
}