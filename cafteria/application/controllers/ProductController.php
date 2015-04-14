<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    
    public function getCategoriesArray(){
        
        $cat_id=array();
        $cat_name=array();
        
        $category_model=new Application_Model_Category();
        $cat_info=$category_model->selectCategory();
        
        for($i=0 ; $i < count($cat_info) ; $i++){
            
            foreach($cat_info[$i] as $key => $value){
                if($key == "id"){
                    array_push($cat_id,$value);
                }
                elseif($key == "cat_name"){
                    array_push($cat_name,$value);
                }
                
            }
        }
        
        $cat_arr=array_combine($cat_id, $cat_name);
        return $cat_arr;
    }

    public function addAction()
    {
        
        $cat_arr=  $this->getCategoriesArray();
        
        $prodform = new Application_Form_Product();
        $catName=$prodform->getElement('cat_id');
        foreach ($cat_arr as $id => $name) {
            $catName->addMultiOption($id, $name);
        }
        $this->view->prodform = $prodform;  //form is var for view carry formx to show  //to put formx in view
        
        if ($this->getRequest()->isPost()) { //press submit
            if ($prodform->isValid($this->getRequest()->getParams())) { 
                $info = $prodform->getValues();
                //var_dump($prodform->getElement("prod_image")->getValue());
                $ext=  end(explode(".",$prodform->getElement("prod_image")->getValue()));
                
                
                $image=rand(8,5148).".".$ext;
                $path="/var/www/cafeteria/public/upload/";
                $info['prod_image']=$image;
                //echo $info['prod_image'];
                
                $adapter = new Zend_File_Transfer_Adapter_Http();
                //var_dump($adapter);
                $adapter->setDestination($path);

                if (!$adapter->receive()) {
                    $messages = $adapter->getMessages();
                    implode("\n", $messages);
                }
                
                $prodform->getElement('prod_image')->addFilter('Rename',  array('target' => $path, 'overwrite' => true));
                if(!$prodform->getElement('prod_image')->receive()){
                    $messages = $prodform->getElement('prod_image')->getMessages();
                    
                    implode("\n", $messages);
                } 
                
                //$fullFilePath = $prodform->prod_image->getFileName();
                //Zend_Debug::dump($info, '$info');
                //Zend_Debug::dump($fullFilePath, '$fullFilePath');
                
                $product_model = new Application_Model_Product();
                //$modelobj->addUser($info);
                if ($product_model->addProduct($info)) {
                    echo 'Product Added Successfully';
                }
            }
        }
        $this->render('form');
    }
    
    public function listAction() {
        $product_model = new Application_Model_Product();

        $this->view->products = $product_model->listProducts();
    }

    public function deleteAction() {
        $id = $this->getRequest()->getParam("id"); //from url
        $product_model = new Application_Model_Product();
        if (isset($id)) {
            $product_model->deleteProduct($id);
            $this->redirect("product/list");
        }
    }
    
    public function editAction()
    {
        $id=  $this->getRequest()->getParam('id');
        
        if(isset($id)){
            $product_model= new Application_Model_Product();
            
            if($product_info=$product_model->selectProductById($id))
            {
                $cat_arr=  $this->getCategoriesArray();
                
                
                $prodform=new Application_Form_Product();

                $catName=$prodform->getElement('cat_id');
                
                foreach ($cat_arr as $id => $name) {
                    $catName->addMultiOption($id, $name);
                }
                $prodform->getElement("Add")->setValue("Update");
                $prodform->removeElement("Reset");
                $prodform->populate($product_info[0]);
                $this->view->prodform=$prodform;
                $this->render('form');
                
            }
            
            if($this->getRequest()->isPost()){
                if($prodform->isValid($this->getRequest()->getParams())){
                    $result=$prodform->getValues();
                    if($product_model->updateProduct($result)){
                        echo "updated";
                    }
                }
            }
        }

    }
    
    public function statusAction() {
        $id = $this->getRequest()->getParam("id"); //from url
        $status = $this->getRequest()->getParam("st"); //from url
        $modelobj = new Application_Model_Product();
        if ($modelobj->updateStatus($id, $status)) {
            
            $this->redirect("product/list");
        }
    }
}





