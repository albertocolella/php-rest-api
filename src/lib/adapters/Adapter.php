<?php

namespace TcRest\lib\adapters;

abstract class Adapter {
    protected static $instance;
    abstract function insert($args);
    abstract function update($args);
    abstract function find($where=array(), $options=array());
    abstract function delete($args); 
    private function __construct($settings=array()){}
    public static function getInstance($settings=array()){
      if (!self::$instance){
        self::$instance = new Adapter($settings);
      }
      return self::$instance;
    }
}