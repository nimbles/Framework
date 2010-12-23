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

namespace Nimbles\App\Config;

use Nimbles\App\Config,
    Nimbles\App\Config\File\FileAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Config
 * @uses       \Nimbles\App\Config\File\FileAbstract
 * @uses       \Nimbles\App\Config\Exception\InvalidDirectory
 */
class Directory {
    /**
     * The parsed config
     * @var \Nimbles\App\Config
     */
    protected $_config;
    
    /**
     * The directory to parse
     * @var string
     */
    protected $_directory;
    
    /**
     * The config section to load
     * @var string
     */
    protected $_section;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options, array(
            'directory',
            'section'
        ))
    }
    
    /**
     * Gets the parsed config
     * @return \Nimbles\App\Config
     */
    public function getConfig() {
        if (null === $this->_config) {
            $this->_config = new Config();
            $this->_parseConfig();
        }
        return $this->_config;
    }
    
    /**
     * Gets the directory to parse
     * @return string
     */
    public function getDirectory() {
        return $this->_directory;
    }
    
    /**
     * Sets the directory to parse
     * @param string $directory
     * @return \Nimbles\App\Config\Directory
     * @throws \Nimbles\App\Config\Exception\InvalidDirectory
     */
    public function setDirectory($directory) {
        if (!is_string($directory) || !is_dir($directory)) {
            throw new Config\Exception\InvalidDirectory('Directory does not exist: ' . $directory);
        }
        
        $this->_directory = $directory;
        return $this;
    }
    
    /**
     * Gets the section to parse
     * @return string 
     */
    public function getSection() {
        return $this->_section;
    }
    
    /**
     * Sets the section to parse
     * @param string $section
     * @return \Nimbles\App\Config\Directory
     */
    public function setSection($section) {
        $this->_section = $section;
        return $this;
    }
    
    /**
     * Parses the directory for config
     * @return void
     */
    protected function _parseConfig() {
        $files = new \RegexIterator( 
            new \DirectoryIterator(
                $this->getDirectory()
            ),
            '/^.+\.(php|inc|json|js|yml)$/i',
            \RegexIterator::GET_MATCH
        );
                
        foreach ($files as $file) {
            if (null !== ($config = FileAbstract::factory(
                $this->getDirectory() . '/' . $file[0],
                $this->getSection()
            ))) {
                $this->getConfig()->merge($config);
            }
        }
    }
}