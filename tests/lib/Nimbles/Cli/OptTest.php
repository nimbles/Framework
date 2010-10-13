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
 * @package    Nimbles-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli;

use Nimbles\Cli\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 * @group      Nimbles-Cli-Opt
 */
class OptTest extends TestCase {
    /**
     * Tests creating an new empty Opt object
     * @return void
     */
    public function testEmptyConstruct() {
        $opt = new \Nimbles\Cli\Opt();

        $this->assertNull($opt->getCharacter());
        $this->assertNull($opt->getAlias());
        $this->assertEquals(\Nimbles\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED, $opt->getParameterType());
        $this->assertNull($opt->getDescription());
        $this->assertNull($opt->isFlagged());
        $this->assertNull($opt->getValue());

        $this->assertEquals('', $opt->getFormattedOpt());
        $this->assertEquals('', $opt->getFormattedAlias());
    }

    /**
     * Tests creating an new Opt object from an array of data
     * @return void
     */
    public function testPopulatedConstruct() {
        $opt = new \Nimbles\Cli\Opt(array(
            'character' => 'a',
            'alias' => 'accept',
            'parameterType' => \Nimbles\Cli\Opt::PARAM_TYPE_OPTIONAL,
            'description' => 'Accept Type'
        ));

        $this->assertEquals('a', $opt->getCharacter());
        $this->assertEquals('accept', $opt->getAlias());
        $this->assertEquals(\Nimbles\Cli\Opt::PARAM_TYPE_OPTIONAL, $opt->getParameterType());
        $this->assertEquals('Accept Type', $opt->getDescription());

        $this->assertNull($opt->isFlagged());
        $this->assertNull($opt->getValue());

        $this->assertEquals('a::', $opt->getFormattedOpt());
        $this->assertEquals('accept::', $opt->getFormattedAlias());
    }

    /**
     * Tests that the \Nimbles\Cli\Opt\Exception\InvalidCharacter exception is thrown when
     * creating an Opt object from invalid character
     * @dataProvider invalidCharacterProvider
     * @param mixed $character
     * @return void
     */
    public function testInvalidCharacter($character) {
        $this->setExpectedException('\Nimbles\Cli\Opt\Exception\InvalidCharacter');

        $opt = new \Nimbles\Cli\Opt();
        $opt->setCharacter($character);
    }

    /**
     * Tests that the \Nimbles\Cli\Opt\Exception\InvalidAlias exception is thrown when creating
     * an Opt object with an invalid alias
     * @dataProvider invalidAliasProvider
     * @param mixed $alias
     * @return void
     */
    public function testInvalidAlias($alias) {
        $this->setExpectedException('\Nimbles\Cli\Opt\Exception\InvalidAlias');

        $opt = new \Nimbles\Cli\Opt();
        $opt->setAlias($alias);
    }

    /**
     * Tests that the \Nimbles\Cli\Opt\Exception\InvalidParameterType exception is thrown when
     * creating an Opt object with an invalid paramater
     * @dataProvider invalidParameterTypeProvider
     * @param mixed $type
     * @return void
     */
    public function testInvalidParameterType($type) {
        $this->setExpectedException('\Nimbles\Cli\Opt\Exception\InvalidParameterType');

        $opt = new \Nimbles\Cli\Opt();
        $opt->setParameterType($type);
    }

    /**
     * Tests the flagging of an option
     * @return void
     */
    public function testFlagged() {
        $opt = new \Nimbles\Cli\Opt();

        $this->assertNull($opt->isFlagged());

        $this->assertTrue($opt->isFlagged(true));
        $this->assertTrue($opt->isFlagged());

        $this->assertFalse($opt->isFlagged(false));
        $this->assertFalse($opt->isFlagged());
    }

    /**
     * Test getting a value of an option
     * @return void
     */
    public function testValue() {
        $opt = new \Nimbles\Cli\Opt();

        $this->assertNull($opt->getValue());
        $opt->setValue('test');
        $this->assertEquals('test', $opt->getValue());
    }

    /**
     * Tests creating an Opt object via the factory method
     * @dataProvider factoryProvider
     * @param string $opt
     * @param string $character
     * @param string $alias
     * @param string $parameterType
     * @return void
     */
    public function testFactory($opt, $character, $alias, $parameterType) {
        $opt = \Nimbles\Cli\Opt::factory($opt);

        $this->assertEquals($character, $opt->getCharacter());
        $this->assertEquals($alias, $opt->getAlias());
        $this->assertEquals($parameterType, $opt->getParameterType());
    }

    /**
     * Data provider for invalid characters
     * @return array
     */
    public function invalidCharacterProvider() {
        return array(
            array('abc'),
            array(1),
            array(''),
            array(null)
        );
    }

    /**
     * Data provider for invalid alias
     * @return array
     */
    public function invalidAliasProvider() {
        return array(
            array(1),
            array(null)
        );
    }

    /**
     * Data provider for invalid parameter types
     * @return array
     */
    public function invalidParameterTypeProvider() {
        return array(
            array(3),
            array(null),
            array(''),
            array(':'),
            array('::')
        );
    }

    /**
     * Data provider for Opt factory
     * @return array
     */
    public function factoryProvider() {
        return array(
            array('a', 'a', null, \Nimbles\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
            array('a:', 'a', null, \Nimbles\Cli\Opt::PARAM_TYPE_REQUIRED),
            array('a::', 'a', null, \Nimbles\Cli\Opt::PARAM_TYPE_OPTIONAL),
            array('accept', null, 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
            array('accept:', null, 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_REQUIRED),
            array('accept::', null, 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_OPTIONAL),
            array('a|accept', 'a', 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
            array('a|accept:', 'a', 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_REQUIRED),
            array('a|accept::', 'a', 'accept', \Nimbles\Cli\Opt::PARAM_TYPE_OPTIONAL),
            array(new \Nimbles\Cli\Opt(), null, null, \Nimbles\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
        );
    }
}