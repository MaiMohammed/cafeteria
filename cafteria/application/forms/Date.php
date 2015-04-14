<?php

class Application_Form_Date extends Zend_Form {

    public function init() {   //order_date

        $date = new Zend_Form_Element_Text("attDat");
        $date->setAttrib("id", "startDate");
        $date->setLabel("Date From :");
        $date->setRequired();

        $enddate = new Zend_Form_Element_Text("endDate");
        $enddate->setAttrib("id", "endDate");
        $enddate->setLabel("Date To :");
        $enddate->setRequired();
        
        $this->addElements(array($date, $enddate));
    }

}
