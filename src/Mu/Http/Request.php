<?php
namespace Mu\Http;

/**
 * @category Mu\Http
 * @package Mu\Http\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Request extends \Mu\Core\Request {
	/**
	 * The query string variables
	 * @var array
	 */
	protected $_query;

	/**
	 * The post variables
	 * @var array
	 */
	protected $_post;

	/**
	 * The files
	 * @var array
	 */
	protected $_files;

	/**
	 * The session variables
	 * @var array
	 */
	protected $_session;

	/**
	 * The cookie variables
	 * @var array
	 */
	protected $_cookie;

	/**
	 * The http headers
	 * @var array
	 */
	protected $_headers;

	/**
	 * Gets a query variable
	 * @param string|null $key
	 * @return array|string|null
	 */
	public function getQuery($key = null) {
		return $this->_getGlobal($this->_query, $key);
	}

	/**
	 * Sets the query variables
	 * @param array|null $query if null will be set to $_GET
	 * @return \Mu\Http\Request
	 */
	public function setQuery(array $query = null) {
	    $this->_query = (null === $query) ? $_GET : $query;
		return $this;
	}

	/**
	 * Gets a post variable
	 * @param string|null $key
	 * @return array|string|null
	 */
	public function getPost($key = null) {
		return $this->_getGlobal($this->_post, $key);
	}

	/**
	 * Sets the post variables
	 * @param array|null $post if null will be set to $_POST
	 * @return \Mu\Http\Request
	 */
	public function setPost(array $post = null) {
		$this->_post = (null === $post) ? $_POST : $post;
		return $this;
	}

	/**
	 * Gets a file
	 * @param string|null $key
	 * @return array|null
	 */
	public function getFiles($key = null) {
		return $this->_getGlobal($this->_files, $key);
	}

	/**
	 * Sets the files
	 * @param array|null $files if null will be set to $_FILES
	 * @return \Mu\Http\Request
	 */
	public function setFiles(array $files = null) {
		$this->_files = (null === $files) ? $_FILES : $files;
		return $this;
	}

	/**
	 * Gets a session variable by key
	 * @param string|null $key
	 * @return mixed
	 */
	public function getSession($key = null) {
	    return $this->_getGlobal($this->_session, $key);
	}

	/**
	 * Sets the session variables, will start session if not already
	 * @param array|null $session if null will be set to $_SESSION
	 * @return \Mu\Cli\Http
	 * @todo set to \Mu\Http\Session instead of $_SESSION
	 */
	public function setSession(array $session = null) {
	    if (null === $session) {
	        if (!headers_sent()) {
	            @session_start(); // session can only be started if headers not sent
	        }
	        $this->_session =& $_SESSION;
	    } else {
	        $this->_session = $session;
	    }

	    return $this;
	}

	/**
	 * Gets a cookie variable by key
	 * @param string|null $key
	 * @return mixed
	 */
	public function getCookie($key = null) {
	    return $this->_getGlobal($this->_cookie, $key);
	}

	/**
	 * Sets the cookie variables
	 * @param array|null $cookie if null will be set to $_COOKIE
	 * @return \Mu\Http\Request
	 * @todo create \Mu\Http\Cookie and assign
	 */
	public function setCookie(array $cookie = null) {
	    $this->_cookie = (null === $cookie) ? $_COOKIE : $cookie;
	    return $this;
	}

	/**
	 * Gets the scheme of the request, http or https
	 * @return string
	 */
	public function getScheme() {
	    if ('on' === $this->getServer('HTTPS')) {
	        return 'https';
	    }

	    return 'http';
	}

	/**
	 * Builds the request, used by factory
	 * @return \Mu\Http\Request|null
	 */
	static public function build() {
	    if ('cli' !== PHP_SAPI) {
	        $request = new self();

	        if (('https' === $request->getScheme) && class_exists('Mu\Https\Request')) {
	            return null;
	        }

	        return $request;
	    }

	    return null;
	}
}