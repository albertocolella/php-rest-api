<?php
namespace TcRest\Tests;

use TcRest\Server;
use TcRest\controllers\AddressController;
use TcRest\models\AddressModel;

class AddressModelTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $server = new Server(array(
            'address' => array('controller' => '\TcRest\controllers\AddressController'),
        ));
        $res = new AddressModel(0);
        $this->assertObjectHasAttribute('name', $res);
    }
    
    public function testLoadAll()
    {
        $server = new Server(array(
            'address' => array('controller' => '\TcRest\controllers\AddressController'),
        ));
        $_GET[0] = 'address';
        $_GET[1] = 1;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/address/1';
        $result = json_decode($server->route());
        $this->assertEquals($result->id, 1);
    }
}
