<?php
namespace Tests\Mu\Core\Mixin;


require_once 'MixinableMock.php';

/**
 * Mixinable Tests
 * @author marc
 *
 */
class MixinableTest extends \Mu\Core\TestCase {

	public function mockProperties() {
		return array(
			array(new MixinPropertiesMock()),
			array(new MixinPropertiesAndMethodsMock())
		);
	}

	/**
     * @dataProvider mockProperties
     */
	public function testReadOnlyProperties($mock) {
		$this->assertEquals('readonly', $mock->readOnly);

		$this->assertTrue(isset($mock->readOnly));
		$this->setExpectedException('\Mu\Core\Mixin\Exception\ReadOnly');
		$mock->readOnly = 'New Value';
	}

	/**
     * @dataProvider mockProperties
     */
	public function testReadAndWriteProperties($mock) {
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


	public function mockMethods() {
		return array(
			array(new MixinMethodsMock()),
			array(new MixinPropertiesAndMethodsMock())
		);
	}

	/**
     * @dataProvider mockMethods
     */
	public function testMethods($mock) {
		$this->assertSame(array(), $mock->testMethod());
		$this->assertSame(array('Hello'), $mock->testMethod('Hello'));
		$this->assertSame(array('Hello', 'World'), $mock->testMethod('Hello', 'World'));
		$object =  new \StdClass();
		$this->assertSame( array('Hello', 'World', $object), $mock->testMethod('Hello', 'World', $object));
	}
}