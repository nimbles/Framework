<?php
/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Core;

use Nimbles\Core\Container\Definition;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 * @uses       \Nimbles\Core\Container\Definition
 */
class Container extends Collection {
    /**
     * Class construct
     * 
     * @param array|\ArrayObject $array
     * @param array $options
     */
    public function __construct($array = null, array $options = null) {
        $options = array_merge(
            (null === $options) ? array() : $options,
            array(
                'type' => 'Nimbles\Core\Container\Definition',
                'indexType' => static::INDEX_ASSOCIATIVE,
                'readonly' => false
            )
        );
        
        parent::__construct($array, $options);
        $this->setFlags(static::ARRAY_AS_PROPS);
    }
    
    /**
     * Factory method for creating an definition
     * @param string                              $index
     * @param array|\Nimbles\Container\Definition $value
     * @return \Nimbles\Container\Definition
     */
    public static function factory($index, $value) {
        if (is_array($value)) {
            $value['id'] = $index; // keep index and id in sync
            return new Definition($value);
        }
        
        if (is_string($value)) {
            $options = array(
                'id' => $index,
                'class' => $value
            );
            
            return new Definition($options);
        }
        
        if ($value instanceof Definition) {
            $value->setId($index); // keep index and id in sync
            return $value;
        }
        
        return null;
    }
}