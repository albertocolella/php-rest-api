<?php
namespace TcRest\controllers;
abstract class BaseController {
    protected $request = array();
    protected $db;
    
    public function __construct($request, $db) {
        $this->request = $request;
        $this->db = $db;
    }
    abstract public function get($args);
    abstract public function post($args);
    abstract public function put($args);
    abstract public function delete($args);
    protected function setHeader($header){
        if(!headers_sent()){
            header($header);
        }
    }
}