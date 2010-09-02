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
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Cli;

use Mu\Core\Response\ResponseAbstract;

/**
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Core\Delegates\Delegatable
 */
class Response extends ResponseAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return parent::_getImplements() + array(
            'Mu\Core\Delegates\Delegatable' => array(
                'delegates' => array(
                    'write' => array('\Mu\Cli\Response', 'writeBody')
                )
            )
        );
    }

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