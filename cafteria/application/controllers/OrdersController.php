<?php

class OrdersController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function myordersAction() {
        $d = new Application_Form_Date();
        $this->view->datex = $d;
        $sdate = $this->getRequest()->getPost();
        if (isset($sdate['date']) && isset($sdate['enddate'])) {
            $this->_helper->viewRenderer->setNoRender();

            $orderobj = new Application_Model_Order();
            $z = Zend_Auth::getInstance();
            //$id = new Zend_Session_Namespace('id');
            //$usrid = $id->id;

            $user_id = $z->getIdentity()->id;

            echo json_encode($orderobj->getOrders($sdate['date'], $sdate['enddate'], $user_id)); //$id

            exit();
        } elseif (isset($sdate['orderId']) && isset($sdate['prodorderId'])) {
            $this->_helper->viewRenderer->setNoRender();

            $orderobj = new Application_Model_Order();
            echo json_encode($orderobj->cancelOrder($sdate['orderId']));

            //echo json_encode($orderobj->deleteOrders($sdate['orderId'], $sdate['prodorderId'])); //$id

            exit();
        } elseif (isset($sdate['date']) && isset($sdate['user_id'])) {
            $this->_helper->viewRenderer->setNoRender();
            $date = $sdate['date'];
            $user_id = $sdate['user_id'];
            $orderobj = new Application_Model_Order();
            echo json_encode($orderobj->getProductOrder($date, $user_id));
            exit();
        }
    }

}
