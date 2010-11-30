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
 * @package    Nimbles-Event
 * @subpackage SelfConnectInterface
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Event;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @subpackage SelfConnectInterface
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
interface SelfConnectInterface {
    /**
     * Gets a mapping of events to callables for self registering
     * @return array
     */
    public function getConnections();
}