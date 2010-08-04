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
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Mixin\Mixinable\MixinableAbstract;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Status;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Header
 * @uses       \Mu\Http\Status
 */

class Client extends MixinableAbstract {

    /**
     * Class implements
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');
}