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
 * @package    Nimbles-Container
 * @subpackage ContainerMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Tests\Lib\Nimbles\Container;

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage ContainerMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class ContainerMock {
    /**
     * The instanceCount
     * @var int
     */
    protected static $_instanceCount = 0;
    
    /**
     * Gets the instance count
     * @return int
     */
    public static function getInstanceCount() {
        return static::$_instanceCount;
    }
    
    /**
     * Class construct, increments counter
     * @return void
     */
    public function __construct() {
        static::$_instanceCount++;
    }
    
    /**
     * Needed by tests
     * @return array
     */
    public function getParameters() {
        return array();
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage ContainerParametersMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class ContainerParametersMock extends ContainerMock {
    /**
     * Parameter 1
     * @var mixed
     */
    public $param1;
    
    /**
     * Parameter 2
     * @var mixed
     */
    public $param2;
    
    /**
     * Needed by tests
     * @return array
     */
    public function getParameters() {
        return array(
            'param1' => $this->param1,
            'param2' => $this->param2
        );
    }
    
    /**
     * Class construct
     * @param mixed $param1
     * @param mixed $param2
     */
    public function __construct($param1, $param2) {
        $this->param1 = $param1;
        $this->param2 = $param2;
        
        parent::__construct();
    }
}