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
 * @package    Nimbles-Singleton
 * @subpackage SingletonTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Pattern;

require_once 'SingletonMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Singleton
 * @subpackage SingletonTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Adapter\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Singleton
 */
class SingletonTest extends TestCase {

    /**
     * Test the getInstance method
     */
    public function testSingleton() {
        $a1 = A::getInstance();
        $a2 = A::getInstance();

        $this->assertEquals($a1, $a2);

        $b = B::getInstance();
        $this->assertNotEquals($a1, $b);
    }
}