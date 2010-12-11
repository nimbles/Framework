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
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Http;

use Nimbles\App\TestCase,
    Nimbles\App\Http\Parameters;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Http
 */
class ParametersTest extends TestCase {
    /**
     * Tests that a parameters object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $parameters = new Parameters();
        $this->assertType('Nimbles\Core\Collection', $parameters);
    }
    
    /**
     * Tests the default options are set
     * @return void
     */
    public function testConstruct() {
        $parameters = new Parameters();
        
        $this->assertEquals('string', $parameters->getType());
        $this->assertEquals(Parameters::INDEX_ASSOCIATIVE, $parameters->getIndexType());
        
        $parameters = new Parameters(null, array(
            'type' => 'int',
            'indexType' => Parameters::INDEX_MIXED
        ));
        
        $this->assertEquals('string', $parameters->getType());
        $this->assertEquals(Parameters::INDEX_ASSOCIATIVE, $parameters->getIndexType());
    }
}