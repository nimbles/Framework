<?php
namespace Tests\Mu\Plugin;

class PluginableMock extends \Mu\Mixin {
	protected $_implements = array('Mu\Plugin\Pluginable' => array(
		'types' => array(
			'simple',
			'restricted' => array(
				'abstract' => '\Tests\Mu\Plugin\PluginAbstract',
			)
		)
	));
}