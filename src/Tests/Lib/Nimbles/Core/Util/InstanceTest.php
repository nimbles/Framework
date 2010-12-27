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
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Util;

require_once 'InstanceMock.php';

use Nimbles\Core\TestCase,
    Nimbles\Core\Util\Instance;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugin\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Util
 */
class InstanceTest extends TestCase {
    /**
     * Tests creating an instance of the given class
     * @param string     $class
     * @param array|null $args
     * @param bool       $valid
     * @return void
     * 
     * @dataProvider instanceProvider
     */
    public function testCreateInstance($class, array $args = null, $valid = true) {
        if (!$valid) {
            $this->setExpectedException('Nimbles\Core\Util\Exception\CreateInstanceFailure');
        }
        $instance = Instance::getInstance($class, $args);
        $this->assertInstanceOf($class, $instance);
    }
    
    /**
     * Data provider for instances
     * @return void
     */
    public function instanceProvider() {
        return array(
            array('Tests\Lib\Nimbles\Core\Util\InstanceMock'),
            array('Tests\Lib\Nimbles\Core\Util\InstanceMockWithParameters', array(1,2)),
            array('Tests\Lib\Nimbles\Core\Util\InstanceMockWithParameters', null, false),
        );
    }
}