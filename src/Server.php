<?php

namespace TcRest;
require 'vendor/autoload.php';
use TcRest\lib\Router;

class Server
{
    protected $routes = array();
    protected $router = null;
    protected $db = null;
    
    public function __construct($routes = array(), $settings = array())
    {
        $this->routes = $routes;
        $settings = $this->parseSettings($settings);        
        $this->router = new Router($this->routes, $settings);
    }
    
    public function route()
    {
        ob_start();
        return $this->router->callRoute();
        ob_end_flush();
    }
    
    private function parseSettings($settings){
        $defaults = array(
            'adapter' => array(
                'class' => 'TcRest\lib\adapters\Csv',
                'source' => dirname(__FILE__).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'adapters'.DIRECTORY_SEPARATOR.'example.csv'
            )
        );
        return array_replace_recursive($defaults, $settings);
    }
    
    
}