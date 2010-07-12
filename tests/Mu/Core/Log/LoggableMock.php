<?php
namespace Tests\Mu\Core\Log;

class LoggableMock extends \Mu\Core\Mixin\MixinAbstract {
	protected $_implements = array('Mu\Core\Log\Loggable');
}