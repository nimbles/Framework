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
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Adapter;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class AdaptableSingleMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Adapter\Adaptable' => array(
                'namespaces' => array(
                    '\Tests\Lib\Mu\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class AdaptableSingleNoPathsMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Adapter\Adaptable');
    }
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class AdaptableAbstractMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Adapter\Adaptable' => array(
                'abstract' => '\Tests\Lib\Mu\Core\Adapter\AdapterAbstract',
                'namespaces' => array(
                    '\Tests\Lib\Mu\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class AdaptableInterfaceMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Adapter\Adaptable' => array(
                'interface' => '\Tests\Lib\Mu\Core\Adapter\AdapterInterface',
                'namespaces' => array(
                    '\Tests\Lib\Mu\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class AdapterSingle{}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
abstract class AdapterAbstract {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Tests\Lib\Mu\Core\Adapter\AdapterAbstract
 */
class AdapterConcrete extends AdapterAbstract {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
interface AdapterInterface {}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Tests\Lib\Mu\Core\Adapter\AdapterInterface
 */
class AdapterImplementor implements AdapterInterface {}