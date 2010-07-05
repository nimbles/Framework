<?php
require_once 'Mu/Core/Loader.php';

/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

/**
 * @category  Mu
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT Licesce
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