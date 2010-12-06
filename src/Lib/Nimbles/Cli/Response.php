<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Cli;

use Nimbles\Core\Response\ResponseAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Response\ResponseAbstract
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Delegates\Delegatable
 */
class Response extends ResponseAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array_merge_recursive(
            parent::_getImplements(),
            array(
                'Nimbles\Core\Delegates\Delegatable' => array(
                    'delegates' => array(
                        /* @codeCoverageIgnoreStart */
                        'write' => function($body) {
                            file_put_contents('php://stdout', $body);
                        }
                        /* @codeCoverageIgnoreEnd */
                    )
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
}