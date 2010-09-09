<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Http\Header;

use Mu\Http\Header;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Collection
 *
 * @uses       \Mu\Http\Header
 */
class Collection extends \Mu\Core\Collection {
    /**
     * Gets the collection type
     * @return string|null
     */
    public function getType() {
        return 'Mu\Http\Header';
    }

    /**
     * Gets the index type, for headers needs to be associtive
     * @return int
     */
    public function getIndexType() {
        return static::INDEX_ASSOCITIVE;
    }

    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        parent::__construct(
            $array,
            array_merge(
                is_array($options) ? $options : array(),
                array(
                    'type' => 'Mu\Http\Header',
                    'indexType' => static::INDEX_ASSOCITIVE
                )
            )
        );
        $this->setFlags(self::ARRAY_AS_PROPS);
    }

    /**
     * Overrides the default behavior of offsetSet so that when setting an entry
     * the type and index type are checked
     * @param string|int $index
     * @param mixed      $value
     * @return void
     */
    public function offsetSet($index, $value) {
        if (is_string($value) && (null !== ($value = \Mu\Http\Header::factory($index, $value, true)))) {
            $index = $value->getName();
        }

        if (null === $value) {
            return;
        }

        parent::offsetSet($index, $value);
    }

    /**
     * Gets a header by its name
     * @param string $name
     * @return \Mu\Http\Header|null
     */
    public function getHeader($name) {
        return $this[$name];
    }

    /**
     * Sets a header
     *
     * @param string|\Mu\Http\Header             $name
     * @param string|\Mu\Http\Header|array|null  $value
     * @param bool                               $append
     * @return \Mu\Http\Header\Collection
     */
    public function setHeader($name, $value = null, $append = false) {
        $append = (bool) $append;

        if (is_array($name) || ($name instanceof \ArrayObject)) {
            foreach ($name as $index => $header) {
                if (is_string($index)) {
                    $this->setHeader($index, $header);
                } else {
                    $this->setHeader($header);
                }
            }
        } else if ($name instanceof Header) {
            $header = $name;
            $name = $header->getName();

            if ($append && $this->offsetExists($name)) {
                $this[$name]->merge($header);
            } else {
                $this[$name] = $header;
            }
        } else if (is_string($name)) {
            if ($value instanceof Header) {
                $name = $value->getName(); // sync to the headers name
                $value = $value->getValue(); // converts to null, string or array
            }

            if (is_string($value) || (null === $value)) {
                $value = array($value);
            }

            foreach ($value as $string) {
                $header = Header::factory($name, $string);
                $name = $header->getName();

                if ($append && array_key_exists($name, $this)) {
                    $this[$name]->merge($header);
                } else {
                    $this[$name] = $header;
                }
            }
        }

        return $this;
    }
}