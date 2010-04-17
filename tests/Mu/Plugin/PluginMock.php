<?php
namespace Tests\Mu\Plugin;

class PluginSingle {}

abstract class PluginAbstract {}
class PluginConcrete extends PluginAbstract {}

interface IPlugin {}
class PluginImplementor implements IPlugin {}

class PluginObserver extends PluginAbstract {
	public function update($object) {
		// updated
	}
}