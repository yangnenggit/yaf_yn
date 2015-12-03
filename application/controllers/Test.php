<?php

class TestController extends Yaf\Controller_Abstract {

    private $lib = null;
    public function init()
    {
       // $this->lib = new libDriver();
    }
    public function indexAction()
    {
        echo 123;
    }
    public function testAction()
    {//默认Action
	  $this->getView()->assign("content", "Hello World");

    }

}
?>
