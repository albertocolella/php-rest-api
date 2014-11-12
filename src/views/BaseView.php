<?php
namespace TcRest\views;
abstract class BaseView {
    protected $args = Array();
    
    public function __construct($args) {
        $this->args = $args;
    }
    abstract public function render($args);
}