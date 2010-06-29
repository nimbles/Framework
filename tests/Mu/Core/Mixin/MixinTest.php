<?php
namespace Tests\Mu\Core\Mixin;

require_once 'MixinMock.php';

/**
 * Mixin Tests
 * @author marc
 *
 */
class MixinTest extends \Mu\Core\TestCase {

	public function testInvalidMixin() {
		$this->setExpectedException('\Mu\Core\Mixin\Exception\MixinableMissing');
		$invalidMixin = new MixinInvalid();		
	}
	
	public function testBadCall() {
		$this->setExpectedException('\BadMethodCallException');
		$emptyMixin = new MixinEmpty();
		$emptyMixin->doSomething();
	}	
}