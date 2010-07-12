<?php
namespace Tests\Mu\Http;

class HeaderTest extends \Mu\Http\TestCase {
    public function testConstruct() {
        $header = new \Mu\Http\Header();
        $this->assertType('\Mu\Core\Mixin\MixinAbstract', $header);
    }

    public function testConstructFromOptions() {
        $header = new \Mu\Http\Header(array(
            'name' => 'Content-Type',
            'value' => 'text/plain'
        ));

        $this->assertEquals('Content-Type', $header->getName());
        $this->assertEquals('text/plain', $header->getValue());

        $this->assertEquals('Content-Type: text/plain', (string) $header);
    }

    public function testNameGetterSetter() {
        $header = new \Mu\Http\Header();

        $this->assertNull($header->getName());

        $header->setName('Content-Type');
        $this->assertEquals('Content-Type', $header->getName());
        $this->assertEquals('Content-Type', (string) $header);
    }

    public function testSetInvalidName() {
        $this->setExpectedException('Mu\Http\Header\Exception\InvalidHeaderName');
        $header = new \Mu\Http\Header();

        $header->setName(true);
    }

    public function testValueGetterSetter() {
        $header = new \Mu\Http\Header(array(
            'name' => 'Accept'
        ));

        $this->assertNull($header->getValue());
        $this->assertEquals('Accept', (string) $header);

        $header->setValue('text/plain');
        $this->assertEquals('text/plain', $header->getValue());
        $this->assertEquals('Accept: text/plain', (string) $header);

        $header->setValue('text/xml', true);
        $this->assertType('array', $header->getValue());
        $this->assertContains('text/plain', $header->getValue());
        $this->assertContains('text/xml', $header->getValue());
        $this->assertEquals('Accept: text/plain, text/xml', (string) $header);

        $header->setValue('text/xml', false);
        $this->assertEquals('text/xml', $header->getValue());
        $this->assertEquals('Accept: text/xml', (string) $header);
    }

    /**
     * @dataProvider factoryProvider
     */
    public function testFactory($name, $string, $expectedName, $expectedValue, $expectedToString) {
        $header = \Mu\Http\Header::factory($name, $string);

        $this->assertEquals($expectedName, $header->getName());
        $this->assertEquals($expectedValue, $header->getValue());
        $this->assertEquals($expectedToString, (string) $header);
    }

    public function factoryProvider() {
        return array(
            array('accept-encoding', null, 'Accept-Encoding', null, 'Accept-Encoding'),
            array('accept-encoding', 'compress', 'Accept-Encoding', 'compress', 'Accept-Encoding: compress'),
            array('accept-encoding', 'compress, gz', 'Accept-Encoding', array('compress', 'gz'), 'Accept-Encoding: compress, gz')
        );
    }
}