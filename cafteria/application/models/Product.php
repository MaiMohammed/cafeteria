<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
    protected $_name = "products"; //table name
    
    function addProduct($data){
       
        return $this->insert($data);
    }
    
    function listProducts() {
        return $this->fetchAll()->toArray();
    }
    
    function deleteProduct($id) {
        
        return $this->delete("id=$id");
    }
    
      function updateProduct($data) {
        if (empty($data['prod_image'])) {
            unset($data['prod_image'])  ;
        }  else {
             $data['prod_image'] = $data['prod_image'];
        }
        $this->update($data, "id=".$data['id']."");
    }
    
    function selectProductById($id) {
        return $this->find($id)->toArray();
        
    }
    function updateStatus($id,$status){
        if($status == 'availabe'){
            return $this->update(array('status' => 'unavailabe'), "id=$id");
            
        }  else {
             return $this->update(array('status' => 'availabe'), "id=$id");
        }
        
    }


}

