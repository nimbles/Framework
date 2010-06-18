<?php
namespace Tests\Mu\Core\Mixin;

class MixinEmpty extends \Mu\Core\Mixin {}
class MixinInvalid extends \Mu\Core\Mixin {
	protected $_implements = array('\Invalid\Class');
}
