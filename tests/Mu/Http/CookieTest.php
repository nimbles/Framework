<?php
namespace Tests\Mu\Http;

use Mu\Http\Cookie;

class CookieTest extends \Mu\Http\TestCase {
    public function testDefaultOptions() {
        $cookie = new Cookie();

        $this->assertEquals(0, $cookie->getExpire());
        $this->assertEquals('/', $cookie->getPath());
        $this->assertNull($cookie->getDomain());
        $this->assertFalse($cookie->getSecure());
        $this->assertFalse($cookie->getHttponly());
    }
}