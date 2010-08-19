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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Config;

require_once 'ConfigurableMock.php';

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Config
 */
class ConfigurableTest extends TestCase {
    /**
     * Tests the mixin properties are created and behave properly
     * @return void
     */
    public function testMixinProperties() {
        $mock = new ConfigurableMock();
        $this->assertType('\Mu\Core\Config', $mock->config);

        $mock->config->a = 1;
        $this->assertEquals(1, $mock->config->a);
    }
}
