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
 * @category  Mu
 * @package   Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Plugin;

class PluginSingle {}

abstract class PluginAbstract {}
class PluginConcrete extends PluginAbstract {}

interface IPlugin {}
class PluginImplementor implements IPlugin {}

class PluginObserver extends PluginAbstract {
    public function update($object) {
        // updated
    }
}
