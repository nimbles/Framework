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
 * @uses       \Nimbles\Config\Config
 * @uses       \Nimbles\Config\File\Exception\InvalidFile
 */
abstract class FileAbstract {
    /**
     * Format types
     * @var string
     */
    const TYPE_PHP  = 'Php';
    const TYPE_JSON = 'Json';
    const TYPE_YAML = 'Yaml';
    
    /**
     * Full path to the file
     * @var string
     */
    protected $_file;
    
    /**
     * Config loaded by file
     * @var \Nimbles\Config\Config
     */
    protected $_config;
    
    /**
     * Gets the full path to the file
     * @return string
     */
    public function getFile() {
        return $this->_file;
    }
    
    /**
     * Sets the full path to the file
     * @param string $file
     * @return \Nimbles\Config\File\FileAbstract
     * @throws \Nimbles\Config\File\Exception\InvalidFile
     */
    public function setFile($file) {
        if (!file_exists($file)) {
            throw new Exception\InvalidFile('File does not exists: ' . $file);
        }
        
        $this->_file = $file;
        return $this;
    }

    /**
     * Gets the config
     * @return \Nimbles\Config\Config
     */
    public function getConfig() {
        if (null === $this->_config) {
            $this->_config = new Config();
        }
        
        return $this->_config;
    }
    
    /**
     * Sets the config
     * @param \Nimbles\Config\Config $config
     * @return \Nimbles\Config\File\FileAbstract
     */
    public function setConfig(Config $config) {
        $this->_config = $config;
        return $this;
    }
    
    /**
     * Class construct
     * @param string $file
     * @return void
     */
    public function __construct($file) {
        $this->setFile($file)
            ->setConfig($this->parse());
    }
    
    /**
     * Parse the file
     * @return void
     */
    abstract public function parse();
    
    /**
     * Factory method to get config from a file
     * @param string 	  $file
     * @param strign|null $type
     */
    static public function factory($file, $type = null) {
        if (!is_string($file)) {
            throw new Exception\InvalidFile('File must be a string');
        }
        
        if (null === $type) { // select type based file extension
            if (false === ($pos = strrpos($file, '.'))) {
                throw new Exception\InvalidFile('Cannot parse file extension from file');
            }
            
            $extension = substr($file, $pos);
            
            switch ($extension) {
                case '.php' :
                case '.inc' :
                    $type = static::TYPE_PHP;
                    break;
                    
                case '.json' :
                case '.js' :
                    $type = static::TYPE_JSON;
                    break;
                
                case '.yml' :
                    $type = static::TYPE_YAML;
                    break;
            }
        }
        
        if ('Nimbles\Config\File\\' !== substr($type, 0, 20)) {
            $type = 'Nimbles\Config\File\\' . $type;
        }
        
        if (!class_exists($type)) {
            // throw
        }
        
        $parser = new $type($file);
        return $parser->getConfig();
    }
}