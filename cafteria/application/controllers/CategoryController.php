<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $catform = new Application_Form_Category();
        
        $this->view->catform = $catform;
        //form is var for view carry formx to show  //to put formx in view
        if ($this->getRequest()->isPost()) { //press submit
            if ($catform->isValid($this->getRequest()->getParams())) { //
                $info = $catform->getValues();
                $category = new Application_Model_Category();
                //$modelobj->addUser($info);
                if ($category->addCategory($info)) {
                    echo 'Category Added Successfully';
                }
            }
        }
    }


}



