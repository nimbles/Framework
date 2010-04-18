<?php
namespace Tests\Mu\Mixin;
require_once 'PHPUnit/Framework.php';
require_once 'MixinMock.php';

/**
 * Mixin Tests
 * @author marc
 *
 */
class MixinTest extends \PHPUnit_Framework_TestCase {

	public function testInvalidMixin() {
		$this->setExpectedException('\Mu\Mixin\Exception\MixinableMissing');
		$invalidMixin = new MixinInvalid();		
	}
	
	public function testBadCall() {
		$this->setExpectedException('\BadMethodCallException');
		$emptyMixin = new MixinEmpty();
		$emptyMixin->doSomething();
	}	
}