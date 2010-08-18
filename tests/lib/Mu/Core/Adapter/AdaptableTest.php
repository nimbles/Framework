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

require_once 'AdaptableMock.php';

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Adapter
 */
class AdaptableTest extends TestCase {
    /**
     * Tests that the adaptable works as expected
     * @param \Mu\Core\Mixin\MixinAbstract $mock
     * @param stdClass                     $validAdapter
     * @param string                       $expectedException
     * @param stdClass                     $invalidAdapter
     * @return void
     *
     * @dataProvider mockProvider
     */
    public function testAdaptable(\Mu\Core\Mixin\MixinAbstract $mock, $validAdapter, $expectedException, $invalidAdapter) {
        $this->assertNull($mock->getAdapter());
        $this->assertNull($mock->adapter);

        $mock->setAdapter($validAdapter);
        $this->assertSame($validAdapter, $mock->getAdapter());
        $this->assertSame($validAdapter, $mock->adapter);

        $this->setExpectedException($expectedException);
        $mock->setAdapter($invalidAdapter);
    }

    /**
     * Data provider for mocks
     * @return array
     */
    public function mockProvider() {
        return array(
            array(new AdaptableSingleMock(), new AdapterSingle(), '\Mu\Core\Adapter\Exception\InvalidAdapter', null),
            array(new AdaptableAbstractMock(), new AdapterConcrete(), '\Mu\Core\Adapter\Exception\InvalidAbstract', new AdapterSingle()),
            array(new AdaptableInterfaceMock(), new AdapterImplementor(), '\Mu\Core\Adapter\Exception\InvalidInterface', new AdapterSingle()),
        );
    }
}
