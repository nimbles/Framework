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
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

require_once 'Nimbles/Core/Loader.php';

/**
 * @category   Nimbles
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT Licesce
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Loader
 */
class Nimbles {
    /**
     * Nimbles instance
     * @var \Nimbles
     */
    static protected $_instance;

    /**
     * Gets and instance of Nimbles
     * @return \Nimbles
     * @todo require and use \Nimbles\Core\Singleton
     */
    static public function getInstance() {
        if (null === static::$_instance) {
            new Nimbles();
        }
        return static::$_instance;
    }

    /**
     * Sets the instance of Nimbles, can be cleared so a refresh is possible
     * @param Nimbles $instance
     * @return void
     */
    static public function setInstance(Nimbles $instance = null) {
        static::$_instance = $instance;
    }

    /**
     * Class construct
     * @return void
     */
    public function __construct() {
        if (null === static::$_instance) {
            $this->_setupEnvironmentVars();
            \Nimbles\Core\Loader::register();
            static::$_instance = $this;
        }
    }

    /**
     * Setup environment variables
     * @return void
     */
    /* @codeCoverageIgnoreStart */
    protected function _setupEnvironmentVars() {
        if (!defined('NIMBLES_PATH')) {
            define('NIMBLES_PATH', realpath(dirname(__FILE__) . '/'));
        }
        if (!defined('NIMBLES_LIBRARY')) {
            define('NIMBLES_LIBRARY', realpath(NIMBLES_PATH . '/Nimbles/'));
        }
    }
    /* @codeCoverageIgnoreEnd */
}