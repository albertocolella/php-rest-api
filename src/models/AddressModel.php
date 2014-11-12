<?php
namespace TcRest\models;

class AddressModel extends BaseModel {
    private $fields = ['name', 'phone', 'address'];
    
    public function __construct($db, $id=null) {
        parent::__construct($db, $id);
        if(!is_null($id)){
            $this->load($id);
        }
    }
    
    public function load($id){
        $el = $this->getDb()->find(['id'=>$id]);
        $this->id = $id;
        $this->name = $el->name;
        $this->phone = $el->phone;
        $this->address = $el->address;
    }
    
    public function loadAll(){
        return $this->getDb()->find(['type'=>'address']);
    }   
    
    function save($args){
        echo "AddressModel#save";
    }
    
    function delete($args){
        echo "AddressModel#delete";
    }
    
    protected function getDb() {
        $this->db->setMapping($this->fields);
        return $this->db;
    }
    
}