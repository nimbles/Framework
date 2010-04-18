<?php
namespace tests\Mu\Mixin;

class MixinPropertiesMock extends \Mu\Mixin {
	protected $_implements = array('tests\Mu\Mixin\MixinableProperties');
}
class MixinableProperties extends \Mu\Mixin\Mixinable {
	public $readOnly = 'readonly';
	public $readAndWrite = null;
	
	public function getObject() {
		return $this;
	}
	
	public function getProperties() {
		return array(
			'readOnly' => function($object, &$mixinable, $get) {
				if (!$get) {
					throw new \Mu\Mixin\Exception\ReadOnly('readOnly property is read only');
				}
				return $mixinable->readOnly;
			},
			'readAndWrite' => function($object, &$mixinable, $get) {			
				if ($get) {
					return $mixinable->readAndWrite;
				} else {
					return $mixinable->readAndWrite = &func_get_arg(3);
				}
			}
		);
	}
}

class MixinMethodsMock extends \Mu\Mixin {
	protected $_implements = array('tests\Mu\Mixin\MixinableMethods');
}
class MixinableMethods extends \Mu\Mixin\Mixinable {
	public function getObject() {
		return $this;
	}
	
	public function getMethods() {
		return array(
			'testMethod' => function($object, &$mixinable) {
				$args = func_get_args();
				array_shift($args);
				array_shift($args);
				return $args;
			},
		);
	}
}

class MixinPropertiesAndMethodsMock extends \Mu\Mixin {
	protected $_implements = array('tests\Mu\Mixin\MixinableProperties', 'tests\Mu\Mixin\MixinableMethods');
}