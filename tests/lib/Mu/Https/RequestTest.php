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
 * @category   Mu
 * @package    Mu-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Https;

use Mu\Https\TestCase;

/**
 * @category   Mu
 * @package    Mu-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Https
 * @group      Mu-Https-Request
 */
class RequestTest extends TestCase {
    /**
     * Test that the request object extends the abstract
     * @return void
     */
    public function testAbstract() {
        $request = new \Mu\Https\Request();
        $this->assertType('Mu\Http\Request', $request);
    }
}
