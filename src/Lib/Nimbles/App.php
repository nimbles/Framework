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
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles;

use Nimbles\App\Config\Directory,
    Nimbles\App\Request\RequestAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @trait      \Nimbles\Core\Event\Events
 * @trait      \Nimbles\Core\Options
 * 
 * @uses       \Nimbles\App\Config
 * @uses       \Nimbles\App\Config\Directory
 * @uses       \Nimbles\App\Request\RequestAbstract
 */
class App {
    /**
     * The application config
     * @var \Nimbles\App\Config
     */
    protected $_config;
    
    /**
     * The path to application config files
     * @var string
     */
    protected $_configPath;
    
    /**
     * The application environment
     * @var string
     */
    protected $_environment;
    
    /**
     * The request object which started the application
     * @var \Nimbles\App\Request\RequestAbstract
     */
    protected $_request;
    
    /**
     * An instance of the application
     * @var \Nimbles\App
     */
    protected static $_instance;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options, array(
            'configPath'
        ), array(
            'environment' => 'production'
        ));
        
        static::$_instance = $this;
    }
    
    /**
     * Gets the instance of the application
     * @return \Nimbles\App
     */
    public static function getInstance() {
        return static::$_instance;
    }
    
    /**
     * Gets the application config
     * @return \Nimbles\App\Config
     */
    public function getConfig() {
        if (null === $this->_config) {
            $directory = new Directory(array(
                'directory' => $this->getConfigPath(),
                'section'   => $this->getEnvironment()
            ));
            
            $this->_config = $directory->getConfig();
        }
        
        return $this->_config;
    }
    
    /**
     * Gets the application config path
     * @return string
     */
    public function getConfigPath() {
        return $this->_configPath;
    }
    
    /**
     * Sets the application config path
     * @param string $path
     * @return \Nimbles\App
     */
    public function setConfigPath($path) {
        $this->_configPath = $path;
        return $this;
    }
    
    /**
     * Gets the application environment
     * @return string
     */
    public function getEnvironment() {
        return $this->_environment;
    }
    
    /**
     * Sets the application environment
     * @param string $environment
     * @return \Nimbles\App
     */
    public function setEnvironment($environment) {
        $this->_environment = $environment;
        return $this;
    }
    
    /**
     * Gets the request that started this application
     * @return \Nimbles\App\Request\RequestAbstract
     */
    public function getRequest() {
        if (null === $this->_request) {
            $this->_request = RequestAbstract::factory();
        }
        
        return $this->_request;
    }
    
    /**
     * Bootstrap the application
     * @return \Nimbles\App
     */
    public function bootstrap() {
        $this->_applyConfig()
            ->fireEvent('bootstrap');
        return $this;
    }
    
    /**
     * Run the application
     * @return \Nimbles\App
     */
    public function run() {
        return $this;
    }
    
    /**
     * Applies the application config
     * @return \Nimbles\App
     */
    protected function _applyConfig() {
        foreach ($this->getConfig() as $key => $value) {
            switch ($key) {
                case 'php' :
                    $this->_applyPhpIniSettings($value);
                    break;
            }
        }
        
        return $this;
    }
    
    /**
     * Applies the php.ini settings
     * @param \ArrayObject $settings
     * @return \Nimbles\App
     */
    protected function _applyPhpIniSettings(\ArrayObject $settings) {
        foreach ($settings as $name => $value) {
            ini_set($name, $value);
        }
        return $this;
    }
}