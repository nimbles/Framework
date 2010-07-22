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
 * @category  Mu
 * @package   Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Mixin
 */

namespace Tests\Mu\Core\Mixin;

require_once 'MixinableMock.php';

/**
 * @category  Mu
 * @package   Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Mixin
 */
class MixinableTest extends \Mu\Core\TestCase {
	/**
	 * Tests read only mixed in properties
     * @dataProvider mockPropertiesProvider
     * @param \Mu\Core\Mixin\MixinAbstract $mock
     * @return void
     */
	public function testReadOnlyProperties(\Mu\Core\Mixin\MixinAbstract $mock) {
		$this->assertEquals('readonly', $mock->readOnly);

		$this->assertTrue(isset($mock->readOnly));
		$this->setExpectedException('\Mu\Core\Mixin\Exception\ReadOnly');
		$mock->readOnly = 'New Value';
	}

	/**
	 * Tests read and write mixed in properties
     * @dataProvider mockPropertiesProvider
     * @param \Mu\Core\Mixin\MixinAbstract $mock
     * @return void
     */
	public function testReadAndWriteProperties(\Mu\Core\Mixin\MixinAbstract $mock) {
		$this->assertEquals($mock->readAndWrite, null);
		$this->assertFalse(isset($mock->readAndWrite));

		$mock->readAndWrite = 'New Value';
		$this->assertEquals('New Value', $mock->readAndWrite);
		$this->assertTrue(isset($mock->readAndWrite));

		$newValue = new \StdClass();
		$mock->readAndWrite = $newValue;
		$this->assertEquals($newValue,$mock->readAndWrite);
		$this->assertTrue(isset($mock->readAndWrite));
	}

	/**
	 * Tests mixed in methods
     * @dataProvider mockMethodsProvider
     * @param \Mu\Core\Mixin\MixinAbstract $mock
     * @return void
     */
	public function testMethods(\Mu\Core\Mixin\MixinAbstract $mock) {
		$this->assertSame(array(), $mock->testMethod());
		$this->assertSame(array('Hello'), $mock->testMethod('Hello'));
		$this->assertSame(array('Hello', 'World'), $mock->testMethod('Hello', 'World'));
		$object =  new \StdClass();
		$this->assertSame( array('Hello', 'World', $object), $mock->testMethod('Hello', 'World', $object));
	}

	/**
	 * Data provider for mock properties
	 * @return array
	 */
	public function mockPropertiesProvider() {
		return array(
			array(new MixinPropertiesMock()),
			array(new MixinPropertiesAndMethodsMock())
		);
	}

	/**
	 * Data provider for mock methods
	 * @return array
	 */
	public function mockMethodsProvider() {
		return array(
			array(new MixinMethodsMock()),
			array(new MixinPropertiesAndMethodsMock())
		);
	}
}