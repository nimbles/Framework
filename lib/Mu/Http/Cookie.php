<?php
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
 * @category  Mu\Http
 * @package   Mu\Http\Cookie
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

/**
 * @category  Mu\Http
 * @package   Mu\Http\Cookie
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Cookie extends \Mu\Core\Mixin\MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Config\Options',
	    'Mu\Core\Delegates\Delegatable' => array(
	        'delegates' => array(
				'setcookie' => 'setcookie',
				'setrawcookie' => 'setrawcookie'
	        )
	    )
    );
}