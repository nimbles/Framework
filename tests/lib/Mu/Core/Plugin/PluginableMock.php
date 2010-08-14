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
 * @package   \Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Plugin;

/**
 * @category  Mu
 * @package   \Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class PluginableMock extends \Mu\Core\Mixin\MixinAbstract {
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
                'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
            )
        )
    ));
}
