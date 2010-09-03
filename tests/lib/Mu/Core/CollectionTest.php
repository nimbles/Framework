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
 * @package    Mu-Core
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core;

use Mu\Core\TestCase,
    Mu\Core\Collection;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Collection
 */
class CollectionTest extends TestCase {
    /**
     * Tests a collection with mixed index
     *
     * @param string|null $type
     * @param array       $validValues
     * @param array       $invalidValues
     * @dataProvider      mixedProvider
     */
    public function testMixedCollection($type, array $validValues, array $invalidValues) {
        $collection = new Collection(null, $type, Collection::INDEX_MIXED);

        foreach ($validValues as $index => $value) {
            $collection[$index] = $value;
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validValues, $type, Collection::INDEX_MIXED);

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, $type, Collection::INDEX_MIXED);
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }
    }

    /**
     * Tests a collection with numeric index
     *
     * @param string|null $type
     * @param array       $validValues
     * @param array       $invalidValues
     * @dataProvider      mixedProvider
     */
    public function testNumericCollection($type, array $validValues, array $invalidValues) {
        $collection = new Collection(null, $type, Collection::INDEX_NUMERIC);

        $invalidIndexes = array();
        foreach ($validValues as $index => $value) {
            $collection[$index] = $value;
            try {
                $invalidIndexes['index' . (string) $index] = $value;
                $collection['index' . (string) $index] = $value;
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validValues, $type, Collection::INDEX_NUMERIC);

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, $type, Collection::INDEX_NUMERIC);
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        if (!empty($invalidIndexes)) {
            try {
                $collection = new Collection($invalidIndexes, $type, Collection::INDEX_NUMERIC);
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }
    }

    /**
     * Tests a collection with associtive index
     *
     * @param string|null $type
     * @param array       $validValues
     * @param array       $invalidValues
     * @dataProvider      mixedProvider
     */
    public function testAssocitiveCollection($type, array $validValues, array $invalidValues) {
        $collection = new Collection(null, $type, Collection::INDEX_ASSOCITIVE);

        $validIndexes = array();
        foreach ($validValues as $index => $value) {
            $validIndexes['index' . (string) $index] = $value;
            $collection['index' . (string) $index] = $value;
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validIndexes, $type, Collection::INDEX_ASSOCITIVE);

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, $type, Collection::INDEX_ASSOCITIVE);
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        if (!empty($validValues)) {
            try {
                // the validValues array has invalidIndexes
                $collection = new Collection($validValues, $type, Collection::INDEX_ASSOCITIVE);
                $this->fail('Excpected exception Mu\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Mu\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }
    }

    /**
     * Tests that the Mu\Core\Collection\Exception\InvalidType exception is thrown when
     * not passing a string as the type
     * @return void
     */
    public function testInvalidTypeConstruct() {
        $this->setExpectedException('Mu\Core\Collection\Exception\InvalidType');
        $collection = new Collection(null, 1);
    }

    /**
     * Tests that the Mu\Core\Collection\Exception\InvalidIndex exception is thrown when
     * not passing a valid indextype
     * @return void
     * @dataProvider invalidIndexTypeProvider
     */
    public function testInvalidIndexConstruct($invalidIndexType) {
        $this->setExpectedException('Mu\Core\Collection\Exception\InvalidIndex');
        $collection = new Collection(null, 'string', $invalidIndexType);
    }

    /**
     * Data provider for collection tests
     * @return array
     */
    public function mixedProvider() {
        $types = array(
            null,
            '',
            'float',
            'int',
            'numeric',
            'string',
            'bool',
            'object',
            'stdClass',
            'array',
            'null',
        );

        foreach ($types as &$type) {
            $vars = array(1, '2', 3.0, new \stdClass(), null, true, array());

            switch ($type) {
                case null :
                case '' :
                    $type = array($type, $vars, array());
                    break;

                case 'float' :
                    $type = array($type, array_splice($vars, 2, 1), $vars);
                    break;

                case 'int' :
                    $type = array($type, array_splice($vars, 0, 1), $vars);
                    break;

                case 'numeric' :
                    $type = array($type, array_splice($vars, 0, 3), $vars);
                    break;

                case 'string' :
                    $type = array($type, array_splice($vars, 1, 1), $vars);
                    break;

                case 'bool' :
                    $type = array($type, array_splice($vars, 5, 1), $vars);
                    break;

                case 'object' :
                case 'stdClass' :
                    $type = array($type, array_splice($vars, 3, 1), $vars);
                    break;

                case 'array' :
                    $type = array($type, array_splice($vars, 6, 1), $vars);
                    break;

                case 'null' :
                    $type = array($type, array_splice($vars, 4, 1), $vars);
                    break;
            }
        }

        return $types;
    }

    /**
     * Data provider of invalid index types
     * @return array
     */
    public function invalidIndexTypeProvider() {
        return array(
            array(-1),
            array('foo'),
            array(null),
            array(true)
        );
    }
}