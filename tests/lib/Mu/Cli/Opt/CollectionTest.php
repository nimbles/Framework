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
 * @package    Mu-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Cli;

use Mu\Cli\TestCase,
    Mu\Cli\Opt\Collection;

/**
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Cli\TestCase
 *
 * @group      Mu
 * @group      Mu-Cli
 * @group      Mu-Cli-Opt
 */
class CollectionTest extends TestCase {
    /**
     * Tests that the collection extends Mu\Core\ArrayObject
     * @return void
     */
    public function testAbstract() {
        $collection = new Collection();
        $this->assertType('\Mu\Core\ArrayObject', $collection);
    }

    /**
     * Tests the collection
     */
    public function testCollection() {
        $collection = new Collection(array(
            'a',
            'b:',
            'c|cee::'
        ));

        $this->assertEquals('ab:c::', $collection->getOptionString());
        $this->assertSame(array('cee::'), $collection->getAliasArray());
        $collection[] ='d|duh';
        $this->assertEquals('ab:c::d', $collection->getOptionString());
        $this->assertSame(array('cee::', 'duh'), $collection->getAliasArray());

        $opt = $collection->c;
        $this->assertType('Mu\Cli\Opt', $opt);
        $this->assertSame($opt, $collection->cee);
    }
}