<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();

        if(!$authorization->hasIdentity() && $this->_request->getActionName() != "login")
         {
           $this->redirect('user/login');
         }
    }

    public function indexAction()
    {
        // action body
    }
    
    public function signupAction()
    {
        
         $form=new Application_Form_Signup();
         $user_model=new Application_Model_User();
         $this->view->form=$form;
         if($this->getRequest()->isPost()){
         if($form->isValid($_POST)){
         $data = $form->getValues();
         $ext = end(explode('.',$form->getElement('user_image')->getValue()));
         $image=rand(0,5148).".".$ext;
         $path = '/var/www/html/cafteria/public/images/'.$image;
         $data['user_image']=$image;
         $form->getElement('user_image')->addFilter('Rename',array('target' => $path,'overwrite' => true));
        // upload the picture
         $form->getElement('user_image')->receive();               
         if($data['user_password'] != $data['Repassword']){
         $this->view->errorMessage = "Password and Confirm Password don't Match ...";
         return;
         }
         if($user_model->checkUnique($data['user_email']))
         {
             $this->view->errorMessage = "Email Already Taken , Please Chose Another One ... ";
         }
         else
         {
         unset($data['Repassword']);
         if ($user_model->addUser($data)) 
            {
                    //$this->redirect("user/list");
                    echo "doneeeeeee";
            }
         
         }
         
         }
         else
         {
            $this->view->form=$form; 
         }
         
         }
         
         else
         {
            $this->view->form=$form; 
         }
        
    }
    
    
    public function listAction() 
    {
        
        $user_model = new Application_Model_User();
        $this->view->users = $user_model->listUsers();
       
        
    }
    public function listpageAction() 
    {
        
        $user_model = new Application_Model_User();
        
        $user_model=$user_model->listpageUsers();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($user_model));
        $paginator->setItemCountPerPage(1)
                  ->setCurrentPageNumber($this->_getParam('page',1));
        
        $this->view->paginator=$paginator;
        
    }
    
   
    public function loginAction()
    {
        
        $form = new Application_Form_Login() ;  
        
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){
        if($form->isValid($this->getRequest()->getParams())){
            $user_email= $this->_request->getParam('user_email');
            $user_password= $this->_request->getParam('user_password');
            $db = Zend_Db_Table::getDefaultAdapter(); 
           
            $authAdapter = new Zend_Auth_Adapter_DbTable($db,'users','user_email','user_password');
            $authAdapter->setIdentity($user_email);
            $user_password=md5($user_password);
            
            $authAdapter->setCredential($user_password);
            $result = $authAdapter->authenticate();
           
            if ($result->isValid()) 
            {
               
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('role','user_name', 'id' ,'user_image','room_no','extension','user_email')));
                
                if(($auth->getIdentity()->user_email!= 'admin@hotmail.com')&&($auth->getIdentity()->role!= 'admin'))
                {
                    //$this->redirect('product/add') ;
                    echo "user";
                }
                
              
                else
                {
                    $this->redirect('user/signup') ;
                }

            }
            else
            {
                     echo " INVALID Email or Password!";
                     //$this->redirect('user/login') ;
            }

    
             
        }
    }
    }
   
    
    
    public function editAction() 
    {
        
        $usermodel=new Application_Model_User();
        $usersdata=$usermodel->getuserbyid($this->getRequest()->getParam('id'));
        $userid=$this->getRequest()->getParam('id');
        $form=new Application_Form_Signup();
        $form->populate($usersdata[0]);
        $form->getElement('user_password')->setRequired(false);
        $form->getElement('user_image')->setRequired(false);
        $form->getElement('Repassword')->setRequired(false);
        $this->view->form=$form;
        $this->render("signup");
        if($this->getRequest()->isPost())
        {
            if($form->isValid($this->getRequest()->getParams()))
            {
                
                if(empty($form->getValues()['user_password']))
                {
                    $form->removeElement('user_password');
                    $form->removeElement('Repassword');
                    if(empty($form->getValues()['user_image']))
                    {
                        $form->removeElement('user_image');
                        


                                              if($usermodel->edituser($form->getValues(),$userid))
                                              {
                                                  $this->redirect("user/list");
                                              }
                                              else{
                                                  $this->redirect("user/edit");
                                              }

                    }
                    else {
                        $ext = end(explode('.',$form->getElement('user_image')->getValue()));
                        $image=rand(0,5148).".".$ext;
                        $path = '/var/www/html/cafteria/public/images/'.$image;
                        $data['user_image']=$image;
                        $form->getElement('user_image')->addFilter('Rename',array('target' => $path,'overwrite' => true));
                       // upload the picture
                        $form->getElement('user_image')->receive();
                         if($usermodel->edituser($form->getValues(),$userid))
                          {
                               $this->redirect("user/list");
                          }
                          else{
                               $this->redirect("user/edit");   
                          }
                 }
                    
                          
                }
                
                else{
                    if($form->getElement('user_password')->getValue() != $form->getElement('Repassword')->getValue())
                    {
                        echo 'password not match ' ;

                    }
                    else {
                      if(empty($form->getValues()['user_image']))
                        {
                        $form->removeElement('user_image');
                        $form->getValues()['user_password']=md5($form->getValues()['user_password']);
                                           $form->removeElement('Repassword');


                                              if($usermodel->edituser($form->getValues(),$userid))
                                              {
                                                  $this->redirect("user/list");
                                              }
                                              else{
                                                  $this->redirect("user/edit");
                                              }

                        }
                    else{
                        $ext = end(explode('.',$form->getElement('user_image')->getValue()));
                        $image=rand(0,5148).".".$ext;
                        $path = '/var/www/html/cafteria/public/images/'.$image;
                        $data['user_image']=$image;
                        $form->getElement('user_image')->addFilter('Rename',array('target' => $path,'overwrite' => true));
                       // upload the picture
                        $form->getElement('user_image')->receive();
                        $form->getValues()['user_password']=md5($form->getValues()['user_password']);
                        $form->removeElement('Repassword');


                                              if($usermodel->edituser($form->getValues(),$userid))
                                              {
                                                  $this->redirect("user/list");
                                              }
                                              else{
                                                  $this->redirect("user/edit");
                                              }
                    }
                                           
                
                        }
                    }
                
            }
            else {
                echo 'form is not valid ' ;
             }
        }
        
    }
    
    public function deleteAction()
    {
        
        $id=$this->getRequest()->getParam("id");
          if(isset($id))
         {
            $usermodel=new Application_Model_User();
            $usermodel->deleteuser($id);
            $this->redirect("user/list");
             
         }
        
    }
    
    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity(); // to destroy session
        $this->redirect('user/login') ;
    }
    
    
    public function forgetpasswordAction()
    {
            
        $form = new Application_Form_Login() ;  
        $form->removeElement('user_password');
        $form->getElement('Login')->setLabel('send');
        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $email= $this->_request->getParam('user_email');
                $usermodel=new Application_Model_User();
                
                if($userid=$usermodel->checkuserEmail($email))
                {
                    
                       $newpassword = substr(hash('sha512',rand()),0,8);

                        
                            $smtpoptions=array(
                            'auth'=>'login',
                            'username'=>'dinamohd.dm@gmail.com',
                            'password'=>'dahbcenter3613621',
                            'ssl'=>'tls',
                            'port'=>587
                        );
                        $mailtransport=new Zend_Mail_Transport_Smtp('smtp.gmail.com',$smtpoptions);
                        $mail = new Zend_Mail();
                        $mail->addTo($email,'to You');
                        $mail->setSubject('Hello  User');
                        $mail->setBodyText('message from our cafeteria your new password is '.$newpassword);
                        $mail->setFrom('dinamohd.dm@gmail.com', 'Um Gamal Cafetria');

                        //Send it!
                        $sent = true;
                        try {
                            $mail->send($mailtransport);
                        } catch (Exception $e){
                           
                            $sent = false;
                        }

                        //Do stuff (display error message, log it, redirect user, etc)
                        if($sent){
                                if($usermodel->updateuseremail(md5($newpassword), $userid[0]['id']))
                                {
                                    echo 'Successfully Sent Please Check your Email';
                                }
                                else {
                                     echo 'Error in Server';
                                }
                                
                            
                        } else {
                            echo 'Failed Sending to your Email Please Check your Settings';
                        }
                    
                        
                    }
                    else {
                        
                    echo 'This Email is not Existed in my Database';
                }
                    
                    
                }
                
            }
        }

      
        
}

