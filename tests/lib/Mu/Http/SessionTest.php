<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase,
    Mu\Http\Session;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Session
 */
class SessionTest extends TestCase {
    public function testIsStarted() {
        $session = new Session();
        $this->assertFalse($session->isStarted());
        $this->assertTrue($session->isStarted(true));
        // check if true status persists
        $this->assertTrue($session->isStarted());
    }
}