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
 * @package    Nimbles-Config
 * @subpackage File
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Config\File;

use Nimbles\Config\Config,
    Nimbles\Config\File\Exception;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage File
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\File\FileAbstract
 *
 * @uses       \Nimbles\Config\Config
 * @uses       \Nimbles\Config\File\Exception\InvalidFile
 */
class Yaml extends FileAbstract {
    /**
     * Parses the file
     * @param string $section
     * @return \Nimbles\Config\Config
     * @throws \Nimbles\Config\File\Exception\InvalidFormat
     */
    public function parse($section = null) {
        if (!extension_loaded('yaml')) {
            throw new Exception\InvalidFormat('Cannot parse file, yaml extension not loaded');
        }
        
        $data = yaml_parse_file($this->getFile(), -1);
        
        if (!is_array($data)) {
            throw new Exception\InvalidFormat('Invalid file contents, must result in an associtive array');
        }
        
        /*
         *  when getting all docs, yaml_parse_file returns a numerical array
         *  containing each document, so for config, we need to get the first
         *  element in each
         */
        $configData = array();
        foreach ($data as $index => $config) {
            reset($config);
            $configData[key($config)] = current($config);
        }
        
        return $this->getSection($configData, $section);
    }
}