<?php

class Application_Model_Order extends Zend_Db_Table_Abstract {

    protected $_name = "orders"; //table name

    function getOrders($date1, $date2, $id) {
        

         $select = $this->select()
                ->from(array('o' => 'orders'), //t1
                        array('order_date', 'user_id', 'order_status', 'id'))  //select cols from table
                ->join(array('r' => 'product_order'), //t2
                        'o.id = r.order_id')
                ->where('o.order_date >= ?', $date1)
                ->where('o.order_status != ?', 'canceled')
                ->where('o.order_date <= ?', $date2)
                ->where('o.user_id = ?', $id);

        $select->setIntegrityCheck(false);
        $row = $this->fetchAll($select)->toArray();
        return $row;
    }

//    function deleteOrders($id_orders, $id_prod_order) {
//        
//        $pro = new Application_Model_Prductorder();
//        $pro->deleteProductOrders($id_prod_order);
//        return $this->delete("id=$id_orders");
//        
//    }
    function cancelOrder($id_orders) {
         return $this->update(array('order_status' => 'canceled'), "id=$id_orders");
        
    }
    
//    function getProductOrder($order_date,$user_id){
//        $select = $this->select();
//        $select->from(array('o' => $this->_name), array())
//        ->join(array('po' => 'product_order'), 'o.id=po.order_id', array("product_quantity","total_price"))
//        ->join(array('p' => 'products'), 'p.id = po.prod_id', array("prod_name","prod_image"))
//        ->where("order_date= ?" , $order_date)
//        ->where("user_id= ?" ,$user_id)->setIntegrityCheck(false);
//        
//        return $this->fetchAll($select)->toArray();
//    }
    
    function getTotalAmount($startDate,$endDate){
        
        $select = $this->select();
        $select->from(array('o' => $this->_name), array())
        ->join(array('u' => 'users'), 'u.id = o.user_id', array("u.user_name as user_name","id"))
        ->join(array('po' => 'product_order'), 'o.id=po.order_id', array("sum(total_price) as total_price"))
        ->where("order_date BETWEEN '".$startDate."' AND '".$endDate."'")
        ->group("u.user_name")
        ->setIntegrityCheck(false);
        
        return $this->fetchAll($select)->toArray();
        
    }
    
    function getTotalAmountForUser($startDate,$endDate,$user_id){
        
        $select = $this->select();
        $select->from(array('o' => $this->_name), array())
        ->join(array('u' => 'users'), 'u.id = o.user_id', array("u.user_name as user_name","id"))
        ->join(array('po' => 'product_order'), 'o.id=po.order_id', array("sum(total_price) as total_price"))
        ->where("order_date BETWEEN '".$startDate."' AND '".$endDate."'")
        ->where("user_id = ?",$user_id)
        ->group("u.user_name")
        ->setIntegrityCheck(false);
        
        return $this->fetchAll($select)->toArray();
        
    }
    
    function getTotalAmountForDate($startDate,$endDate,$user_id){
        $select = $this->select();
        $select->from(array('o' => $this->_name), array("order_date","user_id"))
        ->join(array('po' => 'product_order'), 'o.id=po.order_id', array("sum(total_price) as total_price"))
        ->where("user_id= ?",$user_id)
        ->group("order_date")
        ->having("order_date BETWEEN '".$startDate."' AND '".$endDate."'")->setIntegrityCheck(false);
        return $this->fetchAll($select)->toArray();
    }
    
    function getProductOrder($order_date,$user_id){
        $select = $this->select();
        $select->from(array('o' => $this->_name), array())
        ->join(array('po' => 'product_order'), 'o.id=po.order_id', array("product_quantity","total_price"))
        ->join(array('p' => 'products'), 'p.id = po.prod_id', array("prod_name","prod_image","prod_price"))
        ->where("order_date= ?" , $order_date)
        ->where("user_id= ?" ,$user_id)->setIntegrityCheck(false);
        
        return $this->fetchAll($select)->toArray();
    }
    
    function getNewOrders(){
        $select=  $this->select()->from(array('o' => $this->_name), array("order_date","o.room_no","user_id"))
                  ->join(array('u' => "users"),'u.id=o.user_id',array("user_name"))
                  ->where("o.order_status= 'processing'")
                  ->order("order_date")->setIntegrityCheck(false);;
        //"select order_date, user_name, u.room_no, extension,prod_name,prod_price, product_quantity from orders as o, users as u, products as p, product_order as po where u.id=o.user_id and o.id=po.order_id and p.id=po.prod_id and o.status='processing'group by order_date"
        return $this->fetchAll($select)->toArray();
    }
    
    function getNewOrdersProduct(){
        
    }

}
