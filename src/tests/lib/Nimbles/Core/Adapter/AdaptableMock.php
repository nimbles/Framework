<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Adapter;

use Nimbles\Core\Mixin\MixinAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class AdaptableSingleMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Adapter\Adaptable' => array(
                'namespaces' => array(
                    '\Tests\Lib\Nimbles\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class AdaptableSingleNoPathsMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Adapter\Adaptable');
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class AdaptableAbstractMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Adapter\Adaptable' => array(
                'abstract' => '\Tests\Lib\Nimbles\Core\Adapter\AdapterAbstract',
                'namespaces' => array(
                    '\Tests\Lib\Nimbles\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class AdaptableInterfaceMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Adapter\Adaptable' => array(
                'interface' => '\Tests\Lib\Nimbles\Core\Adapter\AdapterInterface',
                'namespaces' => array(
                    '\Tests\Lib\Nimbles\Core\Adapter'
                )
            )
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class AdapterSingle{}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
abstract class AdapterAbstract {}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Tests\Lib\Nimbles\Core\Adapter\AdapterAbstract
 */
class AdapterConcrete extends AdapterAbstract {}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
interface AdapterInterface {}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Tests\Lib\Nimbles\Core\Adapter\AdapterInterface
 */
class AdapterImplementor implements AdapterInterface {}