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
 * @package    Mu-Https
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Https;

use Mu\Https\TestCase;

/**
 * @category   Mu
 * @package    Mu-Https
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Https
 * @group      Mu-Https-Response
 */
class ResponseTest extends TestCase {
    /**
     * Tests that the http response is of the write abstract
     * @return void
     */
    public function testAbstract() {
        $response = new \Mu\Https\Response();
        $this->assertType('Mu\Http\Response', $response);
    }
}