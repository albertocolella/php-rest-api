<?php
namespace TcRest\views;
class JsonView extends BaseView {
   
    public function __construct($args) {
        parent::__construct($args);
    }
    public function render($args){
        $output = json_encode($args);
        echo $output;
        return $output;
    }
}