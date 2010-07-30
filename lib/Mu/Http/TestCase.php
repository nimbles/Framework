<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  \Mu\Http
 * @package   \Mu\Http\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

require_once 'PHPUnit/Framework.php';

/**
 * @category  \Mu\Http
 * @package   \Mu\Http\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class TestCase extends \Mu\Core\TestCase {
    /**
     * Creates a \Mu\Http\Request with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Request
     */
    public function createRequest($options = null) {
        $request = new \Mu\Http\Request($options);
        $request->setDelegate('getInput', array($this, 'getInput'));

        return $request;
    }

    /**
     * Creates a \Mu\Http\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Response
     */
    public function createResponse($options = null) {
        $response = new \Mu\Http\Response($options);
        $response->setDelegate('write', array($this, 'setOutput'));

        return $response;
    }
}