<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Cli
 * @package   Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Cli;

/**
 * @category  Mu\Cli
 * @package   Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Response extends \Mu\Core\Response\ResponseAbstract {
	/**
	 * Sends the response
	 * @return void
	 */
	public function send() {
		/**
		 * Use simulated stdin from \Mu\Cli\TestCase if in test mode as php on the
		 * command line will just prompt for user input if none piped in
		 */
		if (defined('APPLICATION_ENV') && ('test' === APPLICATION_ENV)) {
			$this->_stdin = TestCase::setStdout($this->getBody());
		} else {
			file_put_contents(STDOUT, $this->getBody());
		}
	}
}