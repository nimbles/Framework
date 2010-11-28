<?php
/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Container;

use Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 * @uses       \Nimbles\Core\Definition
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
                'type' => 'Nimbles\Container\Definition',
                'indexType' => static::INDEX_ASSOCITIVE,
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
            $value['id'] = $index;
            $value = new Definition($value);
        }
        
        if ($value instanceof Definition) {
            $value->setId($index);
        }
        
        return $value;
    }
}