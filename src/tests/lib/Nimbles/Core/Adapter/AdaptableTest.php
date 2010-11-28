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

require_once 'AdaptableMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Adapter
 */
class AdaptableTest extends TestCase {
    /**
     * Tests that the adaptable works as expected
     * @param $mock
     * @param stdClass                     $validAdapter
     * @param string                       $expectedException
     * @param stdClass                     $invalidAdapter
     * @return void
     *
     * @dataProvider mockProvider
     */
    public function testAdaptable($mock, $validAdapter, $actualAdapterClass, $expectedException, $invalidAdapter) {
        $this->assertNull($mock->getAdapter());
        $this->assertNull($mock->adapter);

        $constraint = null;
        if (is_string($validAdapter) && null !== $actualAdapterClass) {
            $constraint = new \PHPUnit_Framework_Constraint_IsInstanceOf($actualAdapterClass);
        } else {
            $constraint = new \PHPUnit_Framework_Constraint_IsIdentical($validAdapter);
        }
        if (null !== $validAdapter && null !== $constraint) {
            $mock->setAdapter($validAdapter);
            $this->assertThat($mock->getAdapter(), $constraint);
            $this->assertThat($mock->adapter, $constraint);
        }

        $this->setExpectedException($expectedException);
        $mock->setAdapter($invalidAdapter);
    }

    /**
     * Data provider for mocks
     * @return array
     */
    public function mockProvider() {
        return array(
            array(new AdaptableSingleMock(), new AdapterSingle(), null, '\Nimbles\Core\Adapter\Exception\InvalidAdapter', null),
            //array(new AdaptableAbstractMock(), new AdapterConcrete(), null, '\Nimbles\Core\Adapter\Exception\InvalidAbstract', new AdapterSingle()),
            //array(new AdaptableInterfaceMock(), new AdapterImplementor(), null, '\Nimbles\Core\Adapter\Exception\InvalidInterface', new AdapterSingle()),

            //array(new AdaptableSingleMock(), 'AdapterSingle', 'Tests\Lib\Nimbles\Core\Adapter\AdapterSingle', '\Nimbles\Core\Adapter\Exception\InvalidAdapter', null),
            //array(new AdaptableAbstractMock(), 'AdapterConcrete', 'Tests\Lib\Nimbles\Core\Adapter\AdapterConcrete', '\Nimbles\Core\Adapter\Exception\InvalidAbstract', new AdapterSingle()),
            //array(new AdaptableInterfaceMock(), 'AdapterImplementor', 'Tests\Lib\Nimbles\Core\Adapter\AdapterImplementor', '\Nimbles\Core\Adapter\Exception\InvalidInterface', new AdapterSingle()),

            //array(new AdaptableSingleNoPathsMock(), null, null, '\Nimbles\Core\Adapter\Exception\InvalidAdapter', 'AdapterSingle'),
        );
    }
}
