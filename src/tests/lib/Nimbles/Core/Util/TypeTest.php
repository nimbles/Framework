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
 * @package    Nimbles-Core
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Util;

use Nimbles\Core\TestCase,
    Nimbles\Core\Util\Type;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugin\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Util
 */
class TypeTest extends TestCase {
    /**
     * Tests that when trying to get a type validator for a non string that
     * an Nimbles\Core\Util\Exception\InvalidType exception is thrown
     * @return void
     */
    public function testInvalidTypeValidator() {
        $this->setExpectedException('Nimbles\Core\Util\Exception\InvalidType');
        Type::getTypeValidator(123);
    }
    
	/**
     * Tests that when trying to get a type validator for a non string that
     * an Nimbles\Core\Util\Exception\InvalidType exception is thrown
     * @return void
     */
    public function testInvalidType() {
        $this->setExpectedException('Nimbles\Core\Util\Exception\InvalidType');
        Type::isType(123, 123);
    }
    
    /**
     * Tests getting the validator type
     * @param string $type
     * @param string $validatorType
     * 
     * @dataProvider typeProvider
     */
    public function testGetValidator($type, $validatorType) {
        $this->assertType($validatorType, Type::getTypeValidator($type));
    }
    
    /**
     * Data provider for types
     * @return void
     */
    public function typeProvider() {
        return array(
            array('float', 'string'),
            array('int', 'string'),
            array('numeric', 'string'),
            array('string', 'string'),
            array('bool', 'string'),
            array('object', 'string'),
            array('array', 'string'),
            array('callable', 'string'),
            array('null', 'string'),
            array(null, 'null'),
            array('foo', 'Closure')
        );
    }
}