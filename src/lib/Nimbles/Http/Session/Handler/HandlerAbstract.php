<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Http\Session\Handler;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
abstract class HandlerAbstract {
    /**
     * Open the session
     *
     * @param string $path The session save path
     * @param string $name The session name
     * @return bool
     */
    abstract public function open($path, $name);

    /**
     * Closes the session
     * @return bool
     */
    abstract public function close();

    /**
     * Reads from the session
     *
     * @param string $id
     * @return mixed
     */
    abstract public function read($id);

    /**
     * Write to the session
     *
     * @param string $id
     * @param mixed $data
     */
    abstract public function write($id, $data);

    /**
     * Destroys the session
     *
     * @param string $id
     */
    abstract public function destroy($id);

    /**
     * Garbage collects session data
     *
     * @param int $lifetime
     */
    abstract public function gc($lifetime);
}