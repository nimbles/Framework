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
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Pattern;

require_once 'AdapterMock.php';


/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Pattern\Adapter\Adaptable
 */
class AdaptableSingleNoConfigMocks {}


/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Pattern\Adapter\Adaptable
 * @trait      \Nimbles\Core\Options
 */
class AdaptableSingleMock {
    public function __construct() {
        $this->setOption('adaptable', array(
            'namespaces' => array(
                '\Tests\Lib\Nimbles\Core\Pattern'
            )
        ));
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Pattern\Adapter\Adaptable
 * @trait      \Nimbles\Core\Options
 */
class AdaptableTypedMock {
    public function __construct() {
        $this->setOption('adaptable', array(
            'type' => '\Tests\Lib\Nimbles\Core\Pattern\AdapterAbstract',
            'namespaces' => array(
                '\Tests\Lib\Nimbles\Core\Pattern'
             )
        ));
    }
}