<?php
namespace Mu\Core;

/**
 * @category Mu\Core
 * @package Mu\Core\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Request extends Mixin {
	/**
	 * Class implements
	 * @var array
	 */
	protected $_implements = array('Mu\Core\Config\Options');

	/**
	 * Array of server variables
	 * @var array
	 */
	protected $_server;

	/**
	 * Gets a server variable by its key
	 * @param string $key
	 * @return string
	 */
	public function getServer($key) {
		if (!is_array($this->_server)) {
			$this->setServer();
		}

		if (!array_key_exists($key, $this->_server)) {
			return null;
		}

		return $this->_server[$key];
	}

	/**
	 * Sets the server variables
	 * @param array $server
	 * @return \Mu\Core\Request
	 */
	public function setServer(array $server = null) {
		$this->_server = (null === $server) ? $_SERVER : $server;
		return $this;
	}

	/**
	 * Class construct
	 * @param array $server
	 * @param array $env
	 */
	public function __construct($options = null) {
		parent::__construct();
		$this->setOptions($options);
	}
}