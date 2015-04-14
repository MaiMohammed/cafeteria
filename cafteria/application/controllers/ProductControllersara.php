<?php

class ProductController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function catAction() {
        $catform = new Application_Form_Category();
        $this->view->catform = $catform;  //form is var for view carry formx to show  //to put formx in view
        if ($this->getRequest()->isPost()) { //press submit
            if ($catform->isValid($this->getRequest()->getParams())) { //
                $info = $catform->getValues();
                $modelobj = new Application_Model_Category();
                //$modelobj->addUser($info);
                if ($modelobj->addCategory($info)) {
                    echo 'Category Added Successfully';
                }
            }
        }
    }

    public function addAction() {
        $objcat = new Application_Model_Category();
        $this->view->cats = $objcat->selectCategory();
        //var_dump($this->view->cats);
        $prodform = new Application_Form_Product();
        $this->view->prodform = $prodform;  //form is var for view carry formx to show  //to put formx in view




        if ($this->getRequest()->isPost()) { //press submit
            if ($prodform->isValid($this->getRequest()->getParams())) {
                $info = $prodform->getValues();
                $fullFilePath = $prodform->prod_image->getFileName();
                //Zend_Debug::dump($info, '$info');
                //Zend_Debug::dump($fullFilePath, '$fullFilePath');
                $modelobj = new Application_Model_Product();
                //$modelobj->addUser($info);
                if ($modelobj->addProduct($info)) {
                    echo 'Product Added Successfully';
                }
            }
        }
        $this->render('form');
    }

    public function listAction() {
        $modelobj = new Application_Model_Product();

        $this->view->products = $modelobj->listProducts();
    }

    public function deleteAction() {
        $id = $this->getRequest()->getParam("id"); //from url
        $modelobj = new Application_Model_Product();
        if (isset($id)) {
            $modelobj->deleteProduct($id);
            $this->redirect("product/list");
        }
    }

    public function editAction() {

        $id = $this->getRequest()->getParam("id"); //from url
        $modelobj = new Application_Model_Product();
        $formx = new Application_Form_Product();
        //$formx->getElement('password')->removeValidator('Zend_Validate_StringLength')->setRequired(false);
        $this->view->form = $formx;
        $prodata = $modelobj->getProductByID($id);
        $formx->populate($prodata[0]);
        if ($this->getRequest()->isPost()) {
            if ($formx->isValid($this->getRequest()->getParams())) { //
                $data = $formx->getValues();
                $modelobj->editProduct($data);
                $this->redirect("product/list");
            }
        }
        $this->render('form');
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
