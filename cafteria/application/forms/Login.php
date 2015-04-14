<?php

class Application_Form_Login extends Zend_Form
{
    
     public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        
        
       
        $user_email = new Zend_Form_Element_Text("user_email") ;
       // $email->setLabel("Email");
        
        $user_email->setAttrib('id', 'username');
        $user_email->setAttrib("placeholder", "Email  ");
        $user_email->setRequired();
        
        
        
        $user_password = new Zend_Form_Element_Password("user_password");
        //$password->setLabel("Password");
        $user_password->setAttrib("placeholder", "Password ");
        $user_password->setAttrib('id', 'password');
        $user_password->setRequired();
        
        
        
        $submit = new Zend_Form_Element_Submit("Login");
        
       
        
        
        $this->addElements(array($user_email, $user_password,$submit));
        
  
        
    }

    
    
}
?>