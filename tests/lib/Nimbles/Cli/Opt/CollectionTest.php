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
 * @package    Nimbles-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli;

use Nimbles\Cli\TestCase,
    Nimbles\Cli\Opt\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 * @group      Nimbles-Cli-Opt
 */
class CollectionTest extends TestCase {
    /**
     * Tests that the collection extends Nimbles\Core\ArrayObject
     * @return void
     */
    public function testAbstract() {
        $collection = new Collection();
        $this->assertType('\Nimbles\Core\ArrayObject', $collection);
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
        $this->assertType('Nimbles\Cli\Opt', $opt);
        $this->assertSame($opt, $collection->cee);
    }
}