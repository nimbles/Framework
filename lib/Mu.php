<?php
require_once 'Mu/Core/Loader.php';

/**
 * Mu Framework
 *
 * LICENCE
 *
 * This shouce file is subject to the MIT licence that is bundled
 * with the package in the file LICENCE.md.
 * It is also available at this URL:
 * http://mu-framework.com/licence/mit
 *
 * @category  Mu
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/licence/mit MIT Licence
 */

/**
 * @category  Mu
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/licence/mit MIT Licence
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