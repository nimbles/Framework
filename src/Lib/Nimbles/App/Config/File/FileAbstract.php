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
 * @uses       \Nimbles\App\Config
 * @uses       \Nimbles\App\Config\File\Exception\InvalidFile
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
     * @var \Nimbles\App\Config
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
     * @return \Nimbles\App\Config\File\FileAbstract
     * @throws \Nimbles\App\Config\File\Exception\InvalidFile
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
     * @return \Nimbles\App\Config
     */
    public function getConfig() {
        if (null === $this->_config) {
            $this->_config = new Config();
        }
        
        return $this->_config;
    }
    
    /**
     * Sets the config
     * @param \Nimbles\App\Config $config
     * @return \Nimbles\App\Config\File\FileAbstract
     */
    public function setConfig(Config $config = null) {
        $this->_config = $config;
        return $this;
    }
    
    /**
     * Class construct, protected as should only be launced via factory
     * @param string      $file
     * @param string|null $section
     * @return void
     */
    protected function __construct($file, $section = null) {
        $this->setFile($file)
            ->setConfig($this->parse($section));
    }
    
    /**
     * Parses the file
     * @param string $section
     * @return \Nimbles\App\Config
     * @throws \Nimbles\Config\File\Exception\InvalidFormat
     */
    abstract public function parse($section = null);
    
    /**
     * Gets the given section's config
     * @param array $data
     * @param string $section
     * @return \Nimbles\App\Config
     */
    public function getSection(array $data, $section = null) {
        if (null === $section) {
            return new Config($data);
        }
        
        $config = new Config();
        
        foreach ($data as $key => &$subconfig) {
            if (preg_match('/^[a-z0-9]+:[a-z0-9]+$/i', $key)) {
                list($child, $parent) = explode(':', $key);

                if (!$config->offsetExists($parent)) {
                    throw new Exception\InvalidConfig('Invalid config, parent config not defined: ' . $parent);
                }

                $config->$child = clone $config->$parent;
                $config->$child->merge($subconfig);
            }
            
            $config->$key = $subconfig;
        }

        if ($config->offsetExists($section)) {
            return $config->$section;
        }

        // return first value, no match to environment found
        return reset($config);
    }
    
    /**
     * Factory method to get config from a file
     * @param string 	  $file
     * @param string|null $section
     * @param string|null $type
     * @throws \Nimbles\App\Config\File\Exception\InvalidFile
     * @throws \Nimbles\App\Config\File\Exception\InvalidFormat
     */
    public static function factory($file, $section = null, $type = null) {
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
        
        $class = ('Nimbles\App\Config\File\\' !== substr($type, 0, 20)) ? 'Nimbles\App\Config\File\\' . $type : $type;
        
        if (!class_exists($class)) {
            throw new Exception\InvalidFile('No parser for found for type: ' . $type);
        }
        
        $parser = new $class($file, $section);
        return $parser->getConfig();
    }
}