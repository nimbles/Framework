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
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

use Nimbles\Core\TestCase,
    Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Collection
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
        $collection = new Collection(null, array(
            'type' => $type,
            'indexType' => Collection::INDEX_MIXED
        ));

        foreach ($validValues as $index => $value) {
            $collection[$index] = $value;
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validValues, array(
            'type' => $type,
            'indexType' => Collection::INDEX_MIXED
        ));

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, array(
                    'type' => $type,
                    'indexType' => Collection::INDEX_MIXED
                ));
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
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
        $collection = new Collection(null, array(
            'type' => $type,
            'indexType' => Collection::INDEX_NUMERIC
        ));

        $invalidIndexes = array();
        foreach ($validValues as $index => $value) {
            $collection[$index] = $value;
            try {
                $invalidIndexes['index' . (string) $index] = $value;
                $collection['index' . (string) $index] = $value;
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validValues, array(
            'type' => $type,
            'indexType' => Collection::INDEX_NUMERIC
        ));

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, array(
                    'type' => $type,
                    'indexType' => Collection::INDEX_NUMERIC
                ));
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        if (!empty($invalidIndexes)) {
            try {
                $collection = new Collection($invalidIndexes, array(
                    'type' => $type,
                    'indexType' => Collection::INDEX_NUMERIC
                ));
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidIndex', $ex);
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
        $collection = new Collection(null, array(
            'type' => $type,
            'indexType' => Collection::INDEX_ASSOCITIVE
        ));

        $validIndexes = array();
        foreach ($validValues as $index => $value) {
            $validIndexes['index' . (string) $index] = $value;
            $collection['index' . (string) $index] = $value;
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }

        foreach ($invalidValues as $index => $value) {
            try {
                $collection[$index] = $value;
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        $collection = new Collection($validIndexes, array(
            'type' => $type,
            'indexType' => Collection::INDEX_ASSOCITIVE
        ));

        if (!empty($invalidValues)) {
            try {
                $collection = new Collection($invalidValues, array(
                    'type' => $type,
                    'indexType' => Collection::INDEX_ASSOCITIVE
                ));
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidType');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidType', $ex);
            }
        }

        if (!empty($validValues)) {
            try {
                // the validValues array has invalidIndexes
                $collection = new Collection($validValues, array(
                    'type' => $type,
                    'indexType' => Collection::INDEX_ASSOCITIVE
                ));
                $this->fail('Excpected exception Nimbles\Core\Collection\Exception\InvalidIndex');
            } catch (\Exception $ex) {
                $this->assertType('Nimbles\Core\Collection\Exception\InvalidIndex', $ex);
            }
        }
    }

    /**
     * Tests that the Nimbles\Core\Collection\Exception\InvalidIndex exception is thrown when
     * not passing a valid indextype
     * @return void
     * @dataProvider invalidIndexTypeProvider
     */
    public function testInvalidIndexConstruct($invalidIndexType) {
        $this->setExpectedException('Nimbles\Core\Collection\Exception\InvalidIndex');
        $collection = new Collection(null, array(
            'type' => 'string',
            'indexType' => $invalidIndexType
        ));
    }

    /**
     * Tests that a collection is read only
     * @return void
     */
    public function testReadOnly() {
        $collection = new Collection(array(1,2,3), array(
            'type' => 'int',
            'indexType' => Collection::INDEX_NUMERIC,
            'readonly' => true
        ));

        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $collection[] = 4;
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