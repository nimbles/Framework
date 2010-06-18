<?php
namespace Tests\Mu\Core\Log;

class LoggableMock extends \Mu\Core\Mixin {
	protected $_implements = array('Mu\Core\Log\Loggable');
}