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

namespace Nimbles\Core;

use Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\ArrayObject
 *
 * @uses       \Nimbles\Core\Collection\Exception\InvalidType
 * @uses       \Nimbles\Core\Collection\Exception\InvalidIndex
 */
class Collection extends ArrayObject {
    /**
     * The different index types
     * @var int
     */
    const INDEX_NUMERIC    = 0;
    const INDEX_ASSOCITIVE = 1;
    const INDEX_MIXED      = 2;

    /**
     * The type of elements this collection can contain
     * @var string|null
     */
    protected $_type;

    /**
     * The index type
     * @var int
     */
    protected $_indexType;

    /**
     * Indicates that the collection is read only
     * @var unknown_type
     */
    protected $_readonly;

    /**
     * Gets the collection type
     * @return string|null
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * Gets the type validation callback
     * @return string|array|\Closure
     */
    public function getTypeValidator() {
        if ((null === ($type = $this->getType())) || ('' === $type)) {
            return null;
        }

        $types = array(
            'float',
            'int',
            'numeric',
            'string',
            'bool',
            'object',
            'array'
        );

        if (in_array($type, $types)) {
            return 'is_' . $type;
        }

        if ('null' === $type) {
            return 'is_null';
        }

        return function ($value) use ($type) {
            return is_a($value, $type);
        };
    }

    /**
     * Gets the index type
     * @return int
     */
    public function getIndexType() {
        return $this->_indexType;
    }

    /**
     * Indicates that the collection is redaonly
     * @return bool
     */
    public function isReadOnly() {
        return $this->_readonly;
    }

    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        parent::__construct();

        if (!is_array($options)) {
            $options = array();
        }

        $options = array_merge(
            array(
                'type' => null,
                'indexType' => static::INDEX_MIXED,
                'readonly' => false,
            ),
            $options
        );

        if ((null !== $options['type']) && !is_string($options['type'])) {
            throw new Collection\Exception\InvalidType('Type must be a string');
        }
        $this->_type = $options['type'];

        if (!in_array($options['indexType'], array(static::INDEX_MIXED, static::INDEX_NUMERIC, static::INDEX_ASSOCITIVE), true)) {
            throw new Collection\Exception\InvalidIndex('Index type must be mixed, numeric or associtive');
        }
        $this->_indexType = $options['indexType'];

        if (is_array($array) || ($array instanceof \ArrayObject)) {
            // this is done so that the overloaded offsetSet is called
            foreach ($array as $index => $value) {
                $this[$index] = $value;
            }
        }

        $this->_readonly = (bool) $options['readonly'];
    }

    /**
     * Overrides the default behavior of offsetSet so that when setting an entry
     * the type and index type are checked
     * @param string|int $index
     * @param mixed      $value
     * @return void
     */
    public function offsetSet($index, $value) {
        if ($this->isReadOnly()) {
            throw new Collection\Exception\ReadOnly('Cannot write to collection when it is read only');
        }

        if (null !== ($validator = $this->getTypeValidator())) {
            if (!call_user_func($validator, $value)) {
                throw new Collection\Exception\InvalidType('Value must be of type: ' . $this->getType());
            }
        }

        switch ($this->getIndexType()) {
            case static::INDEX_NUMERIC :
                if (!is_numeric($index)) {
                    throw new Collection\Exception\InvalidIndex('Index must be numeric');
                }
                break;

            case static::INDEX_ASSOCITIVE :
                if (!is_string($index) || is_numeric($index)) {
                    throw new Collection\Exception\InvalidIndex('Index must be associtive');
                }
                break;
        }

        return parent::offsetSet($index, $value);
    }

    /**
     * Overrides the default behavior of offsetUnset so that items cannot be
     * unset if the collection is readonly
     *
     * @param string|int $index
     * @return void
     */
    public function offsetUnset($index) {
        if ($this->isReadOnly()) {
            throw new Collection\Exception\ReadOnly('Cannot unset to collection when it is read only');
        }
        return parent::offsetUnset($index);
    }
}