<?php
namespace TcRest\Tests;

use TcRest\Server;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function beforeAll(){
        $this->server = new Server(array(
            'address' => array('controller' => '\TcRest\controllers\AddressController'),
        ));
        return $this->server;
    }

    public function testInit()
    {
       
        $this->assertObjectHasAttribute('routes', $this->server);
        return $this->server;
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testRoute()
    {
        $_GET[0] = 'address';
        $_GET[1] = 1;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PATH_INFO'] = '/address';
        $result = json_decode($this->server->route());
        $this->assertEquals(4, count($result));
        return $this->server;
    }
}
