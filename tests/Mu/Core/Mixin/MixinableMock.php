<?php
namespace Tests\Mu\Core\Mixin;

class MixinPropertiesMock extends \Mu\Core\Mixin {
	protected $_implements = array('tests\Mu\Core\Mixin\MixinableProperties');
}

class MixinableProperties extends \Mu\Core\Mixin\Mixinable {
	public $readOnly = 'readonly';
	public $readAndWrite = null;

	public function getObject() {
		return $this;
	}

	public function getProperties() {
		return array(
			'readOnly' => function($object, &$mixinable, $get) {
				if (!$get) {
					throw new \Mu\Core\Mixin\Exception\ReadOnly('readOnly property is read only');
				}
				return $mixinable->readOnly;
			},
			'readAndWrite' => function($object, &$mixinable, $get, $value = null) {
				if ($get) {
					return $mixinable->readAndWrite;
				} else {
					return $mixinable->readAndWrite = $value;
				}
			}
		);
	}
}

class MixinMethodsMock extends \Mu\Core\Mixin {
	protected $_implements = array('Tests\Mu\Core\Mixin\MixinableMethods');
}

class MixinableMethods extends \Mu\Core\Mixin\Mixinable {
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

class MixinPropertiesAndMethodsMock extends \Mu\Core\Mixin {
	protected $_implements = array('Tests\Mu\Core\Mixin\MixinableProperties', 'Tests\Mu\Core\Mixin\MixinableMethods');
}