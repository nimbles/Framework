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
	 * Class implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Config\Options',
	    'Mu\Core\Delegates\Delegatable' => array(
	        'delegates' => array(
	            'write' => array('\Mu\Cli\Response', 'writeBody')
	        )
	    )
	);

	/**
	 * Sends the response
	 * @return void
	 */
	public function send() {
	    $this->write($this->getBody());
	}

	/**
	 * Writes the body to stdout
	 *
	 * @param string $body
	 * @return void
	 */
	static public function writeBody($body) {
        file_put_contents('php://stdout', $body);
	}
}