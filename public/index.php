<?php
// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(dirname(__FILE__) . '/../lib/Mu.php');
new Mu();

class Test extends Mu\Http\Controller {
    public function testAction() {
        $this->getResponse()->setHeader('Content-Type', 'text/plain')
            ->setBody(print_r($this, true));
    }
}

$controller = new Test(
    new Mu\Http\Request(),
    new Mu\Http\Response()
);

$controller->dispatch('testAction');