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

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait       \Nimbles\Core\Adapter\Adaptable
 * @trait       \Nimbles\Config\Configurable
 */
class AdaptableSingleMock {
    public function __construct() {
        $this->getConfig()->adaptable = array(
            'namespaces' => array(
                '\Tests\Lib\Nimbles\Core\Adapter'
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
 * @trait       \Nimbles\Core\Adapter\Adaptable
 */
class AdaptableSingleNoPathsMocks {}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait       \Nimbles\Core\Adapter\Adaptable
 * @trait       \Nimbles\Config\Configurable
 */
class AdaptableAbstractMock {
    public function __construct() {
        $this->getConfig()->adaptable = array(
            'abstract' => '\Tests\Lib\Nimbles\Core\Adapter\AdapterAbstract',
            'namespaces' => array(
                '\Tests\Lib\Nimbles\Core\Adapter'
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
 * @trait       \Nimbles\Core\Adapter\Adaptable
 * @trait       \Nimbles\Config\Configurable
 */
class AdaptableInterfaceMock {
    public function __construct() {
        $this->getConfig()->adaptable = array(
            'interface' => '\Tests\Lib\Nimbles\Core\Adapter\AdapterInterface',
            'namespaces' => array(
                '\Tests\Lib\Nimbles\Core\Adapter'
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