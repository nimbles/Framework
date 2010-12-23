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

namespace Nimbles\Core\Util;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Util
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Type {
    /**
     * Method to check if a value is of a given type
     * @param string $type
     * @param mixed $value
     * @return bool
     */
    public static function isType($type, $value) {
        if (null !== ($validator = static::getTypeValidator($type))) {
            return call_user_func($validator, $value);
        }
        return true;
    }
    
    /**
     * Gets a validator callback for the given type
     * @param string $type
     * @return string|\Closure
     * @throws \Nimbles\Core\Util\Exception\InvalidType
     */
    public static function getTypeValidator($type) {
        if ((null === $type) || ('' === $type)) {
            return null;
        }
        
        if (!is_string($type)) {
            throw new Exception\InvalidType('type must be null or a string');
        }

        $types = array(
            'float',
            'int',
            'numeric',
            'string',
            'bool',
            'object',
            'array',
            'callable',
            'scalar'
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
}