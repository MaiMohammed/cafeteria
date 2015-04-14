<?php

class Application_Form_Signup extends Zend_Form
{

    public function init()
    {
     
        /* Form Elements & Other Definitions Here ... */
        $id=new Zend_Form_Element_Hidden('id');
        
        $name = new Zend_Form_Element_Text("user_name");
        //$name->setLabel("Name * ");
        $name->setAttrib("placeholder", "User Name * ");
        
        
        $name->setRequired();
        
        
        $email = new Zend_Form_Element_Text("user_email");
        //$email->setLabel("Email * ");
        $email->setRequired();
        $email->setAttrib("class", "form-control");
        $email->setAttrib("placeholder", "Correct Email Please * ");
        $email->addValidator(new Zend_Validate_EmailAddress());
        
        
        $password = new Zend_Form_Element_Password("user_password");
        $password->setAttrib("placeholder", "Password *");
        $password->setRequired();
        //$password->setLabel("Password * ");

        $Repassword = new Zend_Form_Element_Password("Repassword");
        $Repassword->setRequired();
        $Repassword->setAttrib("placeholder", "Confirm Password *");
        //$Repassword->setLabel("Confirm Password * ");
        $Repassword->addValidator(new Zend_Validate_StringLength(array('min'=>5)));
        
        
        $roomNumber=new Zend_Form_Element_Text("room_no");
        //$roomNumber->setLabel("Room No. *");
        $roomNumber->setAttrib("placeholder", "Room No. *");
        
        $extension=new Zend_Form_Element_Text("extension");
        $extension->setAttrib("placeholder", "Ext. *");
        //$extension->setLabel("Ext. *");
        
        $user_image=new Zend_Form_Element_File("user_image");
        $user_image->addValidator(new Zend_Validate_File_IsImage());
        $user_image->setLabel('Profile Picture');
        $user_image->setValueDisabled(true);
       
        
        
        
        
        
        
        
            
        $submit = new Zend_Form_Element_Submit("Save");
        $reset = new Zend_Form_Element_Reset("Reset");
        
        
       
        
        
        $this->addElements(array($id,$name, $email, $password,$Repassword,$roomNumber,$extension,$user_image,$submit,$reset));
    }





}

