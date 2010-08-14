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

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class PluginableMock extends MixinAbstract {
    /**
     * The implements for this mock, adds the pluginable mixin
     * with the types simple and a restricted plugins which limits to
     * the \Tests\Mu\Core\Plugin\PluginAbstract abstract class
     * @var array
     */
    protected $_implements = array('Mu\Core\Plugin\Pluginable' => array(
        'types' => array(
            'simple',
            'restricted' => array(
                'abstract' => '\Tests\Lib\Mu\Core\Plugin\PluginAbstract',
            )
        )
    ));
}
