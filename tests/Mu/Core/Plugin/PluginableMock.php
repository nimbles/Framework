<?php
namespace Tests\Mu\Core\Plugin;

class PluginableMock extends \Mu\Core\Mixin {
	protected $_implements = array('Mu\Core\Plugin\Pluginable' => array(
		'types' => array(
			'simple',
			'restricted' => array(
				'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
			)
		)
	));
}