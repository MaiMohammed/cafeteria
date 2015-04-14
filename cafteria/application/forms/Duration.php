<?php

class Application_Form_Duration extends Zend_Form
{

    public function init()
    {
        $date = new Zend_Form_Element_Text("startDate");
        $date->setAttrib("id", "startDate");
        $date->setLabel("Date From :");
        $date->setRequired();

        $enddate = new Zend_Form_Element_Text("endDate");
        $enddate->setAttrib("id", "endDate");
        $enddate->setLabel("Date To :");
        $enddate->setRequired();
        
        $user = new Zend_Form_Element_Select('user_id');
        //$enddate->setAttrib("id", "user");
        $user->setLabel('user :');
        
        $this->addElements(array($date, $enddate,$user));
    
    }


}

