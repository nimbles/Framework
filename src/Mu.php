<?php
require_once 'Mu/Core/Loader.php';

/**
 * @category Mu
 * @package Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Mu {
	/**
	 * Class construct
	 * @return void
	 */
	public function __construct() {
	    if (!defined('MU_PATH')) {
	        define('MU_PATH', realpath(dirname(__FILE__) . '/'));
	    }
        if (!defined('MU_LIBRARY')) {
            define('MU_LIBRARY', realpath(MU_PATH . '/Mu/'));
        }
        Mu\Core\Loader::register();
	}
}