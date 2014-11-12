<?php
namespace TcRest\controllers;
use TcRest\models\AddressModel;
use \Exception as Exception;

class AddressController extends BaseController{
    protected $view;
    
    public function __construct($request, $db) {
        parent::__construct($request, $db);
        $this->view = new \TcRest\views\JsonView($request);
    }
    
    function get($request){
        $this->setHeader("Access-Control-Allow-Methods: *");
        $this->setHeader("Access-Control-Allow-Orgin: *");
        $this->setHeader("Content-Type: application/json");
            if(empty($request)){
                $a = new AddressModel($this->db);
                $this->view->render($a->loadAll());
                return 200;
            }
            $id = $request[0];
            $a = new AddressModel($this->db, $id);
            $this->view->render($a);
            return 200;
    }
    function post($request){
        $this->view->render("AddressController#post");
    }
    function put($request){
        $this->view->render("AddressController#put");
    }
    function delete($request){
        $this->view->render("AddressController#delete");
    }
    
}