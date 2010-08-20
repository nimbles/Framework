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
 * @package    Mu-Core
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Controller\Helper;

use Mu\Core\Controller\Plugin\PluginAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Controller\Plugin\PluginAbstract
 */
abstract class HelperAbstract extends PluginAbstract {
    /**
     * Invoke declared abstract as a helper must have an invoke magic method
     * arguments to be obtained via func_get_args
     * @return mixed
     */
    abstract public function __invoke();
}