 <?php

class Application_Model_User extends Zend_Db_Table_Abstract
{
    protected $_name="users";
    
    function addUser($data)
    {
        if(isset($data['user_password']))
        {
            $data['user_password']=md5($data['user_password']);
            return $this->insert($data);
            
        }
    }
    
    function checkUnique($user_email)
    {
        $select = $this->select()->from($this->_name,array('user_email'))->where('user_email=?',$user_email);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        if($result){
        return true;
        }
        return false;

    }
    
    function listpageUsers()
    {
       $db=  Zend_Db_Table::getDefaultAdapter();
       $result=new Zend_Db_Select($db);
       $result->from('users')->where('role=?','user')->where('user_email!=?','admin@hotmail.com');
  
       
       return $result;

    }
    
    function listUsers()
    {
      
       
       $result=$this->fetchAll($this->select()->where('role=?','user')->where('user_email!=?','admin@hotmail.com'))->toArray();
       return $result;
    }
    
    
     function getUserById($id)
    
    {
        return $this->find($id)->toArray();
    }
    
    function deleteuser($id)
    {
        return $this->delete("id=$id");
        
    }
    function edituser($data,$id)
    {
         if (empty($data['user_password']))
        {
            unset($data['user_password']);
        }
        else
        {
            $data['user_password']=md5($data['user_password']);
        }
        
        return $this->update($data,"id=".$data['id']);
    }
        //return $this->update($data,"id=".$id);
    
    function  checkuserEmail($email)
    {
        return 
        
        $this->fetchAll($this->select()->
       from('users', array('id'))->
       where('user_email=?',$email))->toArray() ;
    }
    
    
    
    
    function  updateuseremail($newpassword,$id)
    {
        return $this->update(array('user_password'=>$newpassword),"id=".$id);
   


}

  function selectUsers() {

               $select=$this->select()->from($this->_name,array("id","user_name"));
               return $this->fetchAll($select)->toArray();
           }

}