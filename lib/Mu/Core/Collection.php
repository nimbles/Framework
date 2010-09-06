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

namespace Mu\Core;

use Mu\Core\Collection;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\ArrayObject
 *
 * @uses       \Mu\Core\Collection\Exception\InvalidType
 * @uses       \Mu\Core\Collection\Exception\InvalidIndex
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
     * Indicates if the collection must be ass
     * @var unknown_type
     */
    protected $_indexType;

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
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, $type = null, $indexType = self::INDEX_MIXED) {
        parent::__construct();

        if ((null !== $type) && !is_string($type)) {
            throw new Collection\Exception\InvalidType('Type must be a string');
        }
        $this->_type = $type;

        if (!in_array($indexType, array(static::INDEX_MIXED, static::INDEX_NUMERIC, static::INDEX_ASSOCITIVE), true)) {
            throw new Collection\Exception\InvalidIndex('Index type must be mixed, numeric or associtive');
        }
        $this->_indexType = $indexType;

        if (is_array($array) || ($array instanceof \ArrayObject)) {
            // this is done so that the overloaded offsetSet is called
            foreach ($array as $index => $value) {
                $this[$index] = $value;
            }
        }
    }

    /**
     * Overrides the default behavior of offsetSet so that when setting an entry
     * the type and index type are checked
     * @param string|int $index
     * @param mixed      $value
     * @return void
     */
    public function offsetSet($index, $value) {
        if  (null !== ($validator = $this->getTypeValidator())) {
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
}