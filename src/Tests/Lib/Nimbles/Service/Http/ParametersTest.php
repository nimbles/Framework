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
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Service\Http;

use Nimbles\Service\TestCase,
    Nimbles\Service\Http\Parameters;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Service\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Service
 * @group      Nimbles-Service-Http
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