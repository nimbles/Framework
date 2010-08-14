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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Plugin;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class PluginSingle {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
abstract class PluginAbstract {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class PluginConcrete extends PluginAbstract {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
interface PluginInterface {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class PluginImplementor implements PluginInterface {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class PluginObserver extends PluginAbstract {
    public function update($object) {
        // updated
    }
}
