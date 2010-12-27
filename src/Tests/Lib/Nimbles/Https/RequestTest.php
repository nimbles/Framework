<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Https;

use Nimbles\Https\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Https
 * @group      Nimbles-Https-Request
 */
class RequestTest extends TestCase {
    /**
     * Test that the request object extends the abstract
     * @return void
     */
    public function testAbstract() {
        $request = new \Nimbles\Https\Request();
        $this->assertInstanceOf('Nimbles\Http\Request', $request);
    }
}
