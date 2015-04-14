<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "categories"; //table name
    
    function addCategory($data){
       
        return $this->insert($data);
    }
    
    function selectCategory() {
        return $this->fetchAll()->toArray();
    }


}

