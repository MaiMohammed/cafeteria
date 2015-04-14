<?php

header('Access-Control-Allow-Origin: *');

class OrderController extends Zend_Controller_Action {

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
            //echo $sdate['date'];
            //echo $sdate['enddate'];
            $this->_helper->viewRenderer->setNoRender();

            $orderobj = new Application_Model_Order();
            $z = Zend_Auth::getInstance();
            //$id = new Zend_Session_Namespace('id');
            //$usrid = $id->id;

             $user_id = $z->getIdentity()->id;
             //echo $user_id;

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
    
    public function checksAction()
    {
        $durationForm=new Application_Form_Duration();
        
        $user_id=array("");
        $user_name=array("");
        
        $user_model=new Application_Model_User();
        $user_info=$user_model->selectUsers();
        
        for($i=0 ; $i < count($user_info) ; $i++){
            
            foreach($user_info[$i] as $key => $value){
                if($key == "id"){
                    array_push($user_id,$value);
                }
                elseif($key == "user_name"){
                    array_push($user_name,$value);
                }
                
            }
        }
        
        $user_arr=array_combine($user_id, $user_name);
        
        $user=$durationForm->getElement('user_id');
        
        foreach ($user_arr as $id => $name) {
            $user->addMultiOption($id, $name);
        }
        
        $this->view->form=$durationForm;
        $order_model = new Application_Model_Order();
        //$this->_helper->layout()->disableLayout();
        $request = $this->getRequest()->getPost();
        
        
        if(isset($request['startDate']) && isset($request['endDate']) && isset($request['user_id'])){
            $this->_helper->viewRenderer->setNoRender();
            $startDate=$request['startDate'];
            $endDate=$request['endDate'];
            $user_id=$request['user_id'];
            //echo $startDate;
            $this->view->order = $order_model->getTotalAmountForUser($startDate,$endDate,$user_id);
        }
        elseif(isset($request['startDate']) && isset($request['endDate']) && isset($request['userId'])){
            $this->_helper->viewRenderer->setNoRender();
            $startDate=$request['startDate'];
            $endDate=$request['endDate'];
            $user_id=$request['userId'];
            //echo "message";
            $this->view->order = $order_model->getTotalAmountForDate($startDate,$endDate,$user_id);
            
        }
        elseif(isset($request['startDate']) && isset($request['endDate'])){
            $this->_helper->viewRenderer->setNoRender();
            $startDate=$request['startDate'];
            $endDate=$request['endDate'];
            //echo $startDate;
            $this->view->order = $order_model->getTotalAmount($startDate,$endDate);
        }
        elseif(isset($request['date']) && isset($request['user_id'])){
            $this->_helper->viewRenderer->setNoRender();
            $date=$request['date'];
            $user_id=$request['user_id'];
            $this->view->order = $order_model->getProductOrder($date,$user_id);
            
        }
        
        
        if(isset($this->view->order)){
            echo json_encode($this->view->order);
            exit();
        }
        
    }

    public function ordersAction()
    {
        $order_model=new Application_Model_Order();
        $request = $this->getRequest()->getPost();
        
        if(isset($request['date']) && isset($request['user_id'])){
            $this->_helper->viewRenderer->setNoRender();
            $order_date=$request['date'];
            $user_id=$request['user_id'];
            $this->view->orders=$order_model->getProductOrder($order_date, $user_id);
            
        }
        elseif(isset($request['data'])){
            $this->_helper->viewRenderer->setNoRender();
            $this->view->orders=$order_model->getNewOrders();

            
            //echo "messages";
        }
        
        if(isset($this->view->orders)){
            echo json_encode($this->view->orders);
            exit();
        }
        
    }
    
    
    

}
