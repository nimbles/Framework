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
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

require_once 'Mu/Core/Loader.php';

/**
 * @category   Mu
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT Licesce
 * @version    $Id$
 *
 * @uses       \Mu\Core\Loader
 */
class Mu {
    /**
     * Mu instance
     * @var \Mu
     */
    static protected $_instance;

    /**
     * Gets and instance of Mu
     * @return \Mu
     * @todo require and use \Mu\Core\Singleton
     */
    static public function getInstance() {
        if (null === self::$_instance) {
            new Mu();
        }
        return self::$_instance;
    }

    /**
     * Class construct
     * @return void
     */
    public function __construct() {
        if (null === self::$_instance) {
            $this->_setupEnvironmentVars();
            \Mu\Core\Loader::register();
            self::$_instance = $this;
        }
    }

    /**
     * Setup environment variables
     * @return void
     */
    protected function _setupEnvironmentVars() {
        if (!defined('MU_PATH')) {
            define('MU_PATH', realpath(dirname(__FILE__) . '/'));
        }
        if (!defined('MU_LIBRARY')) {
            define('MU_LIBRARY', realpath(MU_PATH . '/Mu/'));
        }
    }
}
