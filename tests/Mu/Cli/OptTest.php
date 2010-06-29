<?php
namespace Tests\Mu\Cli;

/**
 * Request Tests
 * @author rob
 *
 */
class OptTest extends \Mu\Cli\TestCase {
	public function testEmptyConstruct() {
		$opt = new \Mu\Cli\Opt();

		$this->assertNull($opt->getCharacter());
		$this->assertNull($opt->getAlias());
		$this->assertEquals(\Mu\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED, $opt->getParameterType());
		$this->assertNull($opt->getDescription());
		$this->assertNull($opt->isFlagged());
		$this->assertNull($opt->getValue());

		$this->assertEquals('', $opt->getFormattedOpt());
		$this->assertEquals('', $opt->getFormattedAlias());
	}

	public function testPopulatedConstruct() {
		$opt = new \Mu\Cli\Opt(array(
			'character' => 'a',
			'alias' => 'accept',
			'parameterType' => \Mu\Cli\Opt::PARAM_TYPE_OPTIONAL,
			'description' => 'Accept Type'
		));

		$this->assertEquals('a', $opt->getCharacter());
		$this->assertEquals('accept', $opt->getAlias());
		$this->assertEquals(\Mu\Cli\Opt::PARAM_TYPE_OPTIONAL, $opt->getParameterType());
		$this->assertEquals('Accept Type', $opt->getDescription());

		$this->assertNull($opt->isFlagged());
		$this->assertNull($opt->getValue());

		$this->assertEquals('a::', $opt->getFormattedOpt());
		$this->assertEquals('accept::', $opt->getFormattedAlias());
	}

	/**
	 * @dataProvider invalidCharacterProvider
	 */
	public function testInvalidCharacter($character) {
		$this->setExpectedException('\Mu\Cli\Opt\Exception\InvalidCharacter');

		$opt = new \Mu\Cli\Opt();
		$opt->setCharacter($character);
	}

	public function invalidCharacterProvider() {
		return array(
			array('abc'),
			array(1),
			array(''),
			array(null)
		);
	}

	/**
	 * @dataProvider invalidAliasProvider
	 */
	public function testInvalidAlias($alias) {
		$this->setExpectedException('\Mu\Cli\Opt\Exception\InvalidAlias');

		$opt = new \Mu\Cli\Opt();
		$opt->setAlias($alias);
	}

	public function invalidAliasProvider() {
		return array(
			array(1),
			array(null)
		);
	}

	/**
	 * @dataProvider invalidParameterTypeProvider
	 */
	public function testInvalidParameterType($type) {
		$this->setExpectedException('\Mu\Cli\Opt\Exception\InvalidParameterType');

		$opt = new \Mu\Cli\Opt();
		$opt->setParameterType($type);
	}

	public function invalidParameterTypeProvider() {
		return array(
			array(3),
			array(null),
			array(''),
			array(':'),
			array('::')
		);
	}

	public function testFlagged() {
		$opt = new \Mu\Cli\Opt();

		$this->assertNull($opt->isFlagged());

		$this->assertTrue($opt->isFlagged(true));
		$this->assertTrue($opt->isFlagged());

		$this->assertFalse($opt->isFlagged(false));
		$this->assertFalse($opt->isFlagged());
	}

	public function testValue() {
		$opt = new \Mu\Cli\Opt();

		$this->assertNull($opt->getValue());
		$opt->setValue('test');
		$this->assertEquals('test', $opt->getValue());
	}

	/**
	 * @dataProvider factoryProvider
	 */
	public function testFactory($opt, $character, $alias, $parameterType) {
		$opt = \Mu\Cli\Opt::factory($opt);

		$this->assertEquals($character, $opt->getCharacter());
		$this->assertEquals($alias, $opt->getAlias());
		$this->assertEquals($parameterType, $opt->getParameterType());
	}

	public function factoryProvider() {
		return array(
			array('a', 'a', null, \Mu\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
			array('a:', 'a', null, \Mu\Cli\Opt::PARAM_TYPE_REQUIRED),
			array('a::', 'a', null, \Mu\Cli\Opt::PARAM_TYPE_OPTIONAL),
			array('accept', null, 'accept', \Mu\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
			array('accept:', null, 'accept', \Mu\Cli\Opt::PARAM_TYPE_REQUIRED),
			array('accept::', null, 'accept', \Mu\Cli\Opt::PARAM_TYPE_OPTIONAL),
			array('a|accept', 'a', 'accept', \Mu\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
			array('a|accept:', 'a', 'accept', \Mu\Cli\Opt::PARAM_TYPE_REQUIRED),
			array('a|accept::', 'a', 'accept', \Mu\Cli\Opt::PARAM_TYPE_OPTIONAL),
			array(new \Mu\Cli\Opt(), null, null, \Mu\Cli\Opt::PARAM_TYPE_NOT_ACCEPTED),
		);
	}
}