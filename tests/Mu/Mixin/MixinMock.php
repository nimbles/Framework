<?php
namespace tests\Mu\Mixin;

class MixinEmpty extends \Mu\Mixin {}
class MixinInvalid extends \Mu\Mixin {
	protected $_implements = array('\Invalid\Class');
}
