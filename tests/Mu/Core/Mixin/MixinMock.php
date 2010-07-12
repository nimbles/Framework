<?php
namespace Tests\Mu\Core\Mixin;

class MixinEmpty extends \Mu\Core\Mixin\MixinAbstract {}
class MixinInvalid extends \Mu\Core\Mixin\MixinAbstract {
	protected $_implements = array('\Invalid\Class');
}
