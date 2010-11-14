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
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Event;

use Nimbles\Event\SelfConnectInterface;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class ListenerMock {
    public function listen1($event) {
        return false;
    }

    public function listen2($event) {
        return true;
    }

    public function listen3($event) {
        return false;
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class ListenerMockSelfConnect extends ListenerMock
    implements SelfConnectInterface {

    public function getConnections() {
        return array(
            'event1' => array($this, 'listen1'),
            'event2' => array($this, 'listen2'),
            'event3' => array($this, 'listen3')
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class ListenerMockInvalidSelfConnect extends ListenerMock
    implements SelfConnectInterface {

    public function getConnections() {
        return null;
    }
}